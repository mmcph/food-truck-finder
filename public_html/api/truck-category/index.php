<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\FoodTruck\TruckCategory;


/**
 * api for the TruckCategory class
 *
 * @author {} <valebmeza@gmail.com>
 * @coauthor Derek Mauldin <derek.e.mauldin@gmail.com>
 * @editor Manuel Escobar III
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
//	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/foodtruck.ini");
//
//	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "POST") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	} if($method === "POST") {

        // enforce the user has a XSRF token
        verifyXsrf();

        //  Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
        $requestContent = file_get_contents("php://input");

        // This Line Then decodes the JSON package and stores that result in $requestObject
        $requestObject = json_decode($requestContent);

        //make sure Truck Category is available (required field)
        if (empty($requestObject->truckCategoryCategoryId) === true) {
            throw(new \InvalidArgumentException ("Category ID does not exist.", 405));

        //  make sure truckId is available
        } if(empty($requestObject->truckCategoryTruckId) === true) {
			throw(new \InvalidArgumentException ("Truck ID does not exist.", 405));
		}

		} else if($method === "POST") {

			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("You must be logged in to post to Truck Category", 403));
			}

			// create new truck category and insert into the database
		$truckCategory = new TruckCategory($requestObject->truckCategoryCategoryId, $requestObject->truckCategoryTruckId);
		$truckCategory->insert($pdo);

			// update reply
			$reply->message = "Truck category created OK";
		}






else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Truck to be deleted
	$TruckCategory = TruckCategory::getTruckCategoryByTruckCategoryCategoryIdAndTruckCategoryTruckId($pdo, $id);
		if($TruckCategory === null) {
			throw(new RuntimeException("truck category does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own TruckCategory
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $TruckCategory->getTruckCategoryId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this truck category", 403));
		}

		// delete TruckCategory
	$TruckCategory->delete($pdo);
		// update reply
		$reply->message = "Truck category deleted OK";
	}

} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);

// finally - JSON encodes the $reply object and sends it back to the front end.
