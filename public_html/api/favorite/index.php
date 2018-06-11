<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\FoodTruck\{
	Favorite
};


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
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/foodtruck.ini");

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize search parameters
	$favoriteProfileId  = filter_input(INPUT_GET, "favoriteProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$favoriteTruckId  = filter_input(INPUT_GET, "favoriteTruckId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


	if($method ==="GET") {
		//set XSRF cookie
		setXsrfCookie();

		//gets a specific favorite based on its composite key
		if ($favoriteProfileId !== null && $favoriteTruckId !==null) {
			$favorite = Favorite::getFavoriteByFavoriteProfileIdAndFavoriteTruckId($pdo, $favoriteProfileId, $favoriteTruckId);

			if($favorite!==null) {
				$reply->data = $favorite;
			}
		} else if(empty($favoriteProfileId) === false) {
			$favorite = Favorite::getFavoriteByFavoriteProfileId($pdo,$favoriteProfileId)->toArray();
			if($favorite !== null) {
				$reply->data =$favorite;
			}
			// get the favorites associated with the truckId
		} else if (empty($favoriteTruckId) === false) {
			$favorite = Favorite::getFavoriteByFavoriteTruckId($pdo, $favoriteTruckId)->toArray();

			if($favorite !== null) {
				$reply->data = $favorite;
			}
		} else {
			//if none of the search parameters are met, throw an exception
			throw new InvalidArgumentException("No favorites here", 404);
		}

	} else if ($method === "POST") {
		$requestContent=file_get_contents("php://input");
		$requestObject= json_decode($requestContent);

		// enforce the user has a XSRF token
		verifyXsrf();

//enforce the user is signed in
		if (empty($_SESSION["profile"]) === true) {

			//|| $_SESSION["profile"]->getProfileId()->toString() !== $favorite->getFavoriteProfileId()->toString()) {
			throw(new \InvalidArgumentException("You must be signed in to favorite a food truck", 403));
		}

		validateJwtHeader();

//todo this is new tests on post ideally will test on get request first
		$testFavorite = Favorite::getFavoriteByFavoriteProfileIdAndFavoriteTruckId($pdo, $_SESSION["profile"]->getProfileId(), $requestObject->favoriteTruckId);
		if($testFavorite !== null){
			throw(new \InvalidArgumentException("You have already favorited this truck!", 403));
		}

		$favorite = new Favorite($_SESSION["profile"]->getProfileId(), $requestObject->favoriteTruckId);
		$favorite->insert($pdo);
		$reply->message = "Favorited successfully";



	} else if($method === "PUT") {

		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);


		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the favorite by composite key
		$favorite = Favorite::getFavoriteByFavoriteProfileIdAndFavoriteTruckId($pdo, $requestObject->favoriteProfileId, $requestObject->favoriteTruckId);
		if ($favorite === null) {
			throw(new RuntimeException("Favorite does not exist", 404));
		}

		validateJwtHeader();

		//enforce the user is signed in and only trying to edit their own favorite
		if (empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId()->toString() !== $favorite->getFavoriteProfileId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this favorite category", 403));
		}

		//validateJwtHeader();
		//perform the actual delete

		$favorite->delete($pdo);
		//update the message
		$reply->message = "Favorite deleted successfully";

		// if any other HTTP request is sent throw an exception

	} else {
		throw new \InvalidArgumentException("invalid http request", 400);
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
// encode and return reply to front end caller
echo json_encode($reply);

// finally - JSON encodes the $reply object and sends it back to the front end.