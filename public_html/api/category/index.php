<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/jwt.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\FoodTruck\Category;


/**
 * API for category
 *
 * @author G Cordova gcordovaone@gmail.com
 */
//verify the session, if it is not active start it
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
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	// sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$categoryName = filter_input(INPUT_GET, "categoryName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	// make sure the id is valid for methods that require it

	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets a post by content
		if(empty($id) === false) {
			$category = Category::getCategoryByCategoryId($pdo, $id);
			if($category !== null) {
				$reply->data = $category;
			}

		} else if(empty($categoryName) === false) {
			$categoryName = Category::getCategoryByCategoryName($pdo, $categoryName);
			if($categoryName !== null) {
				$reply->data = $categoryName;
			}

		} else {
		    $reply->data = Category::getAllCategories($pdo)->toArray();
		}

	} else {
		throw (new InvalidArgumentException("Invalid HTTP request", 400));
	}
	// catch any exceptions that were thrown and update the status and message state variable fields
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);

