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
		//set XSRF cookie
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