<?php
//todo should I be using ../ ?
require_once dirname(__DIR__, 3) . "../vendor/autoload.php";
require_once dirname(__DIR__, 3) . "../php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "../php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "../php/lib/uuid.php";
//todo FoodTruck (DB name) or food-truck-finder (DDL name)? (CHECK OTHER INSTANCES)
require_once("/etc/apache2/FoodTruck/encrypted-config.php");

use Edu\Cnm\FoodTruck\{
	Truck,
	Profile
};


/**
 * api for the Truck class
 *
 * @author {} <valebmeza@gmail.com>
 * @coauthor Derek Mauldin <derek.e.mauldin@gmail.com>
 * @editor Marlon McPherson
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
	$pdo = connectToEncryptedMySQL("/etc/apache2/FoodTruck/PLACEHOLDER.ini");

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	//todo $id seems generic, change to id to reflect state var?
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
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

		//get a specific truck based on arguments provided or all the trucks and update reply
		if(empty($id) === false) {
			$reply->data = Truck::getTruckByTruckId($pdo, $id);
		} else if(empty($truckProfileId) === false) {
			$reply->data = Truck::getTruckByTruckProfileId($pdo, $truckProfileId)->toArray();
		} else if(empty($truckIsOpen) === false) { //todo empty or null? is_null() not working here
			$reply->data = Truck::getTruckByTruckIsOpen($pdo, $truckIsOpen)->toArray();
		} else if(empty($truckName) === false) {
			$reply->data = Truck::getTruckByTruckName($pdo, $truckName)->toArray();
		} else {
			//todo no such method; no use case AFAIK
			$reply->data = Truck::getAllTrucks($pdo)->toArray();
		}
	}

	//PUT and POST if blocks

	else if($method === "PUT" || $method === "POST") {

		// enforce the user has a XSRF token
		verifyXsrf();

		//  Retrieves the JSON package that the front end sent and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument provided here for the function is "php://input". This is a read only stream that allows raw data to be read from the front end request, which is, in this case, a JSON package.
		$requestContent = file_get_contents("php://input");

		// This line then decodes the JSON package and stores that result in $requestObject
		$requestObject = json_decode($requestContent);

		//make sure profileIsOpen is available (required field)
		if(empty($requestObject->tweetContent) === true) {
			throw(new \InvalidArgumentException ("No content for Tweet.", 405));
		}

		// make sure tweet date is accurate (optional field)
		if(empty($requestObject->tweetDate) === true) {
			$requestObject->tweetDate = null;
		} else {
			// if the date exists, Angular's milliseconds since the beginning of time MUST be converted
			$tweetDate = DateTime::createFromFormat("U.u", $requestObject->tweetDate / 1000);
			if($tweetDate === false) {
				throw(new RuntimeException("invalid tweet date", 400));
			}
			$requestObject->tweetDate = $tweetDate;
		}

		//  make sure profileId is available
		if(empty($requestObject->tweetProfileId) === true) {
			throw(new \InvalidArgumentException ("No Profile ID.", 405));
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the tweet to update
			$tweet = Tweet::getTweetByTweetId($pdo, $id);
			if($tweet === null) {
				throw(new RuntimeException("Tweet does not exist", 404));
			}

			//enforce the user is signed in and only trying to edit their own tweet
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $tweet->getTweetProfileId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this tweet", 403));
			}

			// update all attributes
			$tweet->setTweetDate($requestObject->tweetDate);
			$tweet->setTweetContent($requestObject->tweetContent);
			$tweet->update($pdo);

			// update reply
			$reply->message = "Tweet updated OK";

		} else if($method === "POST") {

			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post tweets", 403));
			}

			// create new tweet and insert into the database
			$tweet = new Tweet(generateUuidV4(), $_SESSION["profile"]->getProfileId, $requestObject->tweetContent, null);
			$tweet->insert($pdo);

			// update reply
			$reply->message = "Tweet created OK";
		}

	}