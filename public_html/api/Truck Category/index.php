<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\FoodTruck\{
	TruckCategory,
	Category,
	Truck
};


/**
 * api for the TruckCategory class
 *
 * @author {} <valebmeza@gmail.com>
 * @coauthor Derek Mauldin <derek.e.mauldin@gmail.com>
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

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$truckCategoryCategoryId = filter_input(INPUT_GET, "truckCategoryCategoryId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$truckCategoryTruckId = filter_input(INPUT_GET, "truckCategoryTruckId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}


















else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Tweet to be deleted
	$TruckCategory = TruckCategory::getTruckCategoryByTruckCategoryCategoryIdAndTruckCategoryTruckId($pdo, $id);
		if($TruckCategory === null) {
			throw(new RuntimeException("Truck Category does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own TruckCategory
		if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $TruckCategory->getTruckCategoryId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this tweet", 403));
		}

		// delete TruckCategory
	$TruckCategory->delete($pdo);
		// update reply
		$reply->message = "Truck Category deleted OK";
	}
