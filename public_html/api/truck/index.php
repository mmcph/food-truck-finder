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
	Vote,
	TruckCategory
};


/**
 * api for the truck class
 *
 * @author {} <valebmeza@gmail.com>
 * @coauthor Derek Mauldin <derek.e.mauldin@gmail.com>
 * @editor G Cordova
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
	//get profile from profile
	// mock a logged in user by forcing the session. This is only for testing purposes and should not be in the live code.

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$truckCategories = filter_input(INPUT_GET, "truckCategories", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
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

		//get specific truck(s) based on arguments provided and update reply
		if(empty($id) === false) {
		    $truckData = new stdClass();
			$truckData->truck = Truck::getTruckByTruckId($pdo, $id);
			//todo Is this needed? We'll need category IDs to grab category names from Angular storage
			$truckData->truckCategories = TruckCategory::getTruckCategoriesByTruckCategoryTruckId($pdo, $id)->toArray();
			$truckData->truckVote = Vote::getVoteCountByVoteTruckId($pdo, $id);
			$reply->data = $truckData;



//todo added this && ... probably not necessary since this action will only be available from owner profile.
		} else if(empty($truckProfileId) === false && $_SESSION["profile"]->getProfileIsOwner() === 1) {
			$reply->data->truck = Truck::getTruckByTruckProfileId($pdo, $truckProfileId)->toArray();



		} else if(empty($truckCategories) === false) {
			$truckCategories = @json_decode($truckCategories);
			if(empty($truckCategories) === true || is_array($truckCategories) === false) {
				throw(new \InvalidArgumentException("CODE 18: truck selections are subject to operator error"));
			}
			$reply->data = Truck::getCategoriesAndTrucksByCategoryId($pdo, $truckCategories);
		} else {
			$reply->data = Truck::getTruckByTruckIsOpen($pdo, 1)->toArray();



		}

		//PUT and POST if blocks

	} else if($method === "PUT" || $method === "POST") {

		if (empty( $_SESSION["profile"]) || $_SESSION["profile"]->getProfileIsOwner() === 1) {
			throw new InvalidArgumentException("nananananana Batman", 400);
		}

		// enforce the user has a XSRF token
		verifyXsrf();

		//Retrieve the JSON package that the front end sent and store it in $requestContent.
		$requestContent = file_get_contents("php://input");

		//decode the JSON package and store the result in $requestObject
		$requestObject = json_decode($requestContent);

//todo ripped out "required params", there's not one that's required for every get.

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


			//check optional params, if empty set to null
			if(empty($requestObject->truckBio) === true) {
				$requestObject->truckBio = $truck->getTruckBio();
			}

			if(empty($requestObject->truckIsOpen) === true) {
				$requestObject->truckIsOpen = $truck->getTruckIsOpen();
			}

			if(empty($requestObject->truckLatitude) === true) {
				$requestObject->truckLatitude = $truck->getTruckLatitude();
			}

			if(empty($requestObject->truckLongitude) === true) {
				$requestObject->truckLongitude = $truck->getTruckLongitude();
			}

			if(empty($requestObject->truckName) === true) {
				$requestObject->truckName = $truck->getTruckName();
			}

			if(empty($requestObject->truckPhone) === true) {
				$requestObject->truckPhone = $truck->getTruckPhone();
			}

			if(empty($requestObject->truckUrl) === true) {
				$requestObject->truckUrl = $truck->getTruckUrl();
			}

			//enforce the user is signed in and only trying to edit their own truck
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $truck->getTruckProfileId()->toString()) {
				throw(new \InvalidArgumentException("A truck may only be edited by the truck's owner.", 403));
			}


			validateJwtHeader();


			// update all attributes
			$truck->setTruckBio($requestObject->truckBio);
			$truck->setTruckIsOpen(1);
			$truck->setTruckLatitude($requestObject->truckLatitude);
			$truck->setTruckLongitude($requestObject->truckLongitude);
			$truck->setTruckName($requestObject->truckName);
			$truck->setTruckPhone($requestObject->truckPhone);
			$truck->setTruckUrl ($requestObject->truckUrl);
			$truck->update($pdo);

			// update reply
			$reply->message = "Truck updated successfully.";

		} else if($method === "POST") {
			// enforce the user is signed in
			if(empty($_SESSION["profile"]->getProfileId()->toString()) === true) {
				throw(new \InvalidArgumentException("Only logged in users may add a truck.", 403));
			}

			validateJwtHeader();

			// create new truck and insert into the database
			$truck = new Truck(generateUuidV4(), $_SESSION["profile"]->getProfileId(), $requestObject->truckBio, $requestObject->truckIsOpen, $requestObject->truckLatitude, $requestObject->truckLongitude, $requestObject->truckName, $requestObject->truckPhone, $requestObject->truckUrl);
			$truck->insert($pdo);

			// update reply
			$reply->message = "truck created successfully.";
		}

//		DELETE BLOCK

	} else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the truck to be deleted //
		$truck = Truck::getTruckByTruckId($pdo, $id);
		if($truck === null) {
			throw(new RuntimeException("This truck does not exist.", 404));
		}

		//enforce the user is signed in and only trying to edit their own truck
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $truck->getTruckProfileId()->toString()) {
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

if($reply->data === null) {
	unset($reply->data);
}

echo json_encode($reply);

// finally - JSON encodes the $reply object and sends it back to the front end.