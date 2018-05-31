<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
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

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$favoriteProfileId = filter_input(INPUT_GET, "favoriteProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//
    if(method==="GET"){
        //set XSRF cookie
        setXsrfCookie();

        //gets a specific favorite associated based on its composite key
        if ($favoriteProfileId !== null && $favoriteTruckId !==null) {
            $favorite = Favorite::getFavoriteByFavoriteProfileIdAndFavoriteTruckId($pdo, $favoriteProfileId, $favoriteTruckId);

            if($favorite!==null) {
                $reply->data = $favorite;
            }
            //if none of the search parameters are met, throw an exception
        } else if(empty($favoriteProfileId) === false) {
    $favorite = Favorite::getFavoriteByFavoriteProfileId($pdo,$favoriteProfileId)->toArray();
    if($favorite !== null) {
            $reply->data =$favorite;
    }
    // get the favorites associated with the truckId
        } else if (empty($favoriteTruckId)=== false){
            $favorite = Favorite::getFavoriteByFavoriteTruckId($pdo, $favoriteTruckId)->toArray();

            if($favorite !== null) {
                $reply->data = $favorite;
            }
        } else {
            throw new InvalidArgumentException("incorrect search parameters", 404);
        }

    }
    //elseif ()



	 t require it
	if(($method === "DELETE" || $method === "POST") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}







	else if($method === "POST") {
		// enforce the user has a XSRF token
		verifyXsrf();

		//  Retrieves the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestContent = file_get_contents("php://input");

		// This Line Then decodes the JSON package and stores that result in $requestObject
		$requestObject = json_decode($requestContent);

		//make sure Truck Category is available (required field)
		if(empty($requestObject->profileId) === true) {
			throw(new \InvalidArgumentException ("No content for TruckCategory.", 405));
		}

		//  make sure favoriteTruckId is available
		if(empty($requestObject->truckId) === true) {
			throw(new \InvalidArgumentException ("No Favorite Truck ID.", 405));
		}

	} else if($method === "POST") {

		// enforce the user is signed in
		if(empty($_SESSION["profile"]) === true) {
			throw(new \InvalidArgumentException("You must be logged in to save a favorite", 403));
		}

		// create new favorite and insert into the database
		$favorite = new Favorite(generateUuidV4(), $_SESSION["profile"]->getProfileId, $requestObject->favoriteTruckId, null);
		$favorite->insert($pdo);

		// update reply
		$reply->message = "Favorite created OK";
	}










	else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Truck to be deleted
		$FavoriteProfileId = Favorite::getFavoriteProfileId($pdo, $id);
		if($FavoriteProfileId === null) {
			throw(new RuntimeException("Favorite Profile does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own TruckCategory
		if(empty($_SESSION["favorite"]) === true || $_SESSION["favorite"]->getFavoriteProfileId() !== $FavoriteProfileId->getFavoriteProfileId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this favorite category", 403));
		}


		// delete TruckCategory
		$FavoriteProfileId->delete($pdo);
		// update reply
		$reply->message = "Favorite Profile deleted OK";
	}

} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
header("Content-type: application/json");
echo json_encode($reply);

// finally - JSON encodes the $reply object and sends it back to the front end.
