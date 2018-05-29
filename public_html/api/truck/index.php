<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\FoodTruck\{
	Truck,
	Profile,
	Favorite,
	Vote,
	TruckCategory
};


/**
 * api for the truck class
 *
 * @author {} <valebmeza@gmail.com>
 * @coauthor Derek Mauldin <derek.e.mauldin@gmail.com>
 * @editor MMCPH
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/foodtruck.ini");

	//todo regarding mock logged in user session for testing

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$truckProfileId = filter_input(INPUT_GET, "truckProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$truckBio = filter_input(INPUT_GET, "truckBio", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$truckIsOpen = filter_input(INPUT_GET, "truckIsOpen", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$truckLatitude = filter_input(INPUT_GET, "truckLatitude", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$truckLongitude = filter_input(INPUT_GET, "truckLongitude", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$truckName = filter_input(INPUT_GET, "truckName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$truckPhone = filter_input(INPUT_GET, "truckPhone", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$truckUrl = filter_input(INPUT_GET, "truckUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// GET if block
	if($method === "GET") {

		setXsrfCookie();

//		required gets:
//		get all trucks
//			user search
//		get all open trucks
//			user search
//		get trucks by name
//			user search
//		get trucks by truck profile ID
//			for owner
//		get truck by ID
//			for vote / favorite / truckcategory
//			for owner

		//get specific truck(s) based on arguments provided and update reply
		if(empty($id) === false) {
			$reply->data = Truck::getTruckByTruckId($pdo, $id);
		} else if(empty($truckProfileId) === false) {
			$reply->data = Truck::getTruckByTruckProfileId($pdo, $truckProfileId)->toArray();
		} else if(empty($truckName) === false) {
			$reply->data = Truck::getTruckByTruckName($pdo, $truckName)->toArray();
		} else {
			$reply->data = Truck::getTruckByTruckIsOpen($pdo, 1)->toArray();
		}

		//PUT and POST if blocks

	} else if($method === "PUT" || $method === "POST") {

		// enforce the user has a XSRF token
		verifyXsrf();

		//Retrieve the JSON package that the front end sent and store it in $requestContent.
		$requestContent = file_get_contents("php://input");

		//decode the JSON package and store the result in $requestObject
		$requestObject = json_decode($requestContent);

		//todo why do this? some requests will update only truckIsOpen instead of the entire truck.

		//make sure truckIsOpen is available (required field)
		if(empty($requestObject->truckIsOpen) === true) {
			throw(new \InvalidArgumentException ("truckIsOpen is a required value.", 405));
		}

		//make sure truckName is available (required field)
		if(empty($requestObject->truckName) === true) {
			throw(new \InvalidArgumentException ("truckName is a required value.", 405));
		}

		//todo added from beer proj, necessary?
		//check optional params, if empty set to null
		if(empty($requestObject->truckBio) === true) {
			$requestObject->truckBio = null;
		}

		if(empty($requestObject->truckLatitude) === true) {
			$requestObject->truckLatitude = null;
		}

		if(empty($requestObject->truckLongitude) === true) {
			$requestObject->truckLongitude = null;
		}

		if(empty($requestObject->truckPhone) === true) {
			$requestObject->truckPhone = null;
		}

		if(empty($requestObject->truckUrl) === true) {
			$requestObject->truckUrl = null;
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the truck to update
			$truck = Truck::getTruckByTruckId($pdo, $id);
			if($truck === null) {
				throw(new RuntimeException("This truck does not exist.", 404));
			}

			//enforce the user is signed in and only trying to edit their own truck
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $truck->getTruckProfileId()->toString()) {
				throw(new \InvalidArgumentException("A truck may only be edited by the truck owner.", 403));
			}

			// update all attributes
			$truck->setTruckBio($requestObject->truckBio);
			$truck->setTruckIsOpen($requestObject->truckIsOpen);
			$truck->setTruckLatitude($requestObject->truckLatitude);
			$truck->setTruckLongitude($requestObject->truckLongitude);
			$truck->setTruckName($requestObject->truckName);
			$truck->setTruckPhone($requestObject->truckPhone);
			$truck->setTruckUrl($requestObject->truckUrl);
			$truck->update($pdo);

			// update reply
			$reply->message = "truck updated successfully.";

		} else if($method === "POST") {

			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("Only logged in users may add a truck.", 403));
			}

			// create new truck and insert into the database
			//todo hard-code truckIsOpen to 0 (closed)? What about Lat/Long?
			$truck = new Truck(generateUuidV4(), $_SESSION["profile"]->getProfileId, $requestObject->truckBio, 0, $requestObject->truckLatitude, $requestObject->truckLongitude, $requestObject->truckName, $requestObject->truckPhone, $requestObject->truckUrl);
			$truck->insert($pdo);

			// update reply
			$reply->message = "truck created successfully.";
		}

//		DELETE BLOCK

	} else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the truck to be deleted
		$truck = Truck::getTruckByTruckId($pdo, $id);
		if($truck === null) {
			throw(new RuntimeException("This truck does not exist.", 404));
		}

		//enforce the user is signed in and only trying to edit their own truck
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $truck->getTruckProfileId()) {
			throw(new \InvalidArgumentException("This truck may only be deleted by its owner.", 403));
		}

		// delete truck
		$truck->delete($pdo);
		// update reply
		$reply->message = "truck deleted successfully.";
	}

} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);

// finally - JSON encodes the $reply object and sends it back to the front end.