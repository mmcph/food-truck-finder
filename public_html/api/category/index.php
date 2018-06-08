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
	$categoryTruckId = filter_input(INPUT_GET, "categoryTruckId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$categoryName = filter_input(INPUT_GET, "categoryName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true )) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets a post by content
		if(empty($id) === false) {
			$category = Category::getCategoryByCategoryId($pdo, $id);
			if($category !== null) {
				$reply->data = $category;
			}
		} else if(empty($categoryTruckId) === false) {
			$categoryTruckId = Category::getCategoryByCategoryId($pdo, $categoryTruckId)->toArray();
			if($categoryTruckId !== null) {
				$reply->data = $categoryTruckId;
			}
		} else if(empty($categoryName) === false) {
			$categoryName = Category::getCategoryByCategoryName($pdo, $categoryName);
			if($categoryName !== null) {
				$reply->data = $categoryName;
			}
		}
	} elseif($method === "PUT" || $method === "POST") {
		//enforce that the XSRF token is present in the header
		verifyXsrf();
		//enforce the end user has a JWT token
		validateJwtHeader();
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		if($method === "PUT") {
			//enforce the user is signed in and only trying to edit their own category
			if(empty($_SESSION["category"]) === true || $_SESSION["category"]->getCategoryId()->toString() !== $id) {
				throw(new \InvalidArgumentException("You are not allowed to access this category", 403));
			}
			//retrieve the category to be updated
			$category = Category::getCategoryByCategoryId($pdo, $id);
			if($category === null) {
				throw(new RuntimeException("category does not exist", 404));
			}
			//category profile id
			if(empty($requestObject->categoryTruckId) === true) {
				throw(new \InvalidArgumentException ("No category profile", 405));
			}
			//category name is a required field
			if(empty($requestObject->categoryName) === true) {
				throw(new \InvalidArgumentException ("No category name present", 405));
			}
			$category->setCategoryTruckId($requestObject->categoryTruckId);
			$category->setCategoryName($requestObject->categoryName);
			$category->update($pdo);
			// update reply
			$reply->message = "category information updated";
		} elseif($method === "POST") {
			// enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to create a category", 403));
			}
			// create a new card and insert it into the database
			$category = new Category(generateUuidV4(), $_SESSION["profile"]->getProfileId(), $requestObject->categoryName);
			$category->insert($pdo);
			// update reply
			$reply->message = "category created OK";
		}
		// delete method
	} elseif($method === "DELETE") {
		//verify the XSRF Token
		verifyXsrf();
		//enforce the end user has a JWT token
		//validateJwtHeader();
		$category = Category::getCategoryByCategoryId($pdo, $id);
		if($category === null) {
			throw (new RuntimeException("category does not exist"));
		}
		//enforce the user is signed in and only trying to edit their own category
		if(empty($_SESSION["category"]) === true || $_SESSION["category"]->getCategoryId()->toString() !== $category->getCategoryId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to access this category", 403));
		}
		validateJwtHeader();
		//delete the post from the database
		$category->delete($pdo);
		$reply->message = "category Deleted";
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

