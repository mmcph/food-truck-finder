<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
use Edu\Cnm\FoodTruck\Vote;
/**
 * Api for the Vote class
 *
 * @author george kephart
 * edited by yjohnson6@cnm.edu
 */
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

    //sanitize the search parameters
    $voteProfileId = filter_input(INPUT_GET, "voteProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $voteTruckId = filter_input(INPUT_GET, "voteTruckId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    if ($method === "GET") {
        if($voteTruckId !== null){
            $reply->data = Vote::getVoteCountByVoteTruckId($pdo, $voteTruckId);
        }
        setXsrfCookie();
    } else if ($method === "POST") {
        //decode the response from the front end
        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);

        //enforce that the end user has a XSRF token.
        verifyXsrf();
        //enforce the end user has a JWT token
        // enforce the user is signed in
        if (empty($_SESSION["profile"]) === true) {
            throw(new \InvalidArgumentException("You must first log in to vote", 403));
        }

        validateJwtHeader();

        $vote = Vote::getVoteByVoteProfileIdAndVoteTruckId($pdo, $_SESSION["profile"]->getProfileId(), $requestObject->voteTruckId);

        if ($vote !== null) {
            //delete the vote
            $vote->delete($pdo);
            //update the message
            $reply->message = "Vote successfully deleted";
        }

        //validateJwtHeader();
        $vote = new Vote($_SESSION["profile"]->getProfileId(), $requestObject->voteTruckId, $requestObject->voteValue);
        $vote->insert($pdo);
        $reply->message = "foodtruck voted on successfully";
    } else if ($method === "DELETE") {
        //decode the response from the front end
        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);
        //enforce the end user has a XSRF token.
        verifyXsrf();
        //enforce the end user has a JWT token
        //validateJwtHeader();
        //grab the vote by its composite key
        $vote = Vote::getVoteByVoteProfileIdAndVoteTruckId($pdo, $requestObject->voteProfileId, $requestObject->voteTruckId);
        if ($vote === null) {
            throw (new RuntimeException("Vote does not exist"));
        }

        //enforce the user is signed in and only trying to delete their own vote
        if (empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() ->toString() !== $vote->getVoteProfileId()->toString()) {
            throw(new \InvalidArgumentException("You are not allowed to delete this vote", 403));
        }

        //validateJwtHeader();
        //perform the actual delete
        $vote->delete($pdo);
        //update the message
        $reply->message = "Vote successfully deleted";

        // if any other HTTP request is sent throw an exception
    } else {
        throw new \InvalidArgumentException("invalid http request", 400);
    }
    //catch any exceptions that is thrown and update the reply status and message
}   catch (\Exception | \TypeError $exception) {
        $reply->status = $exception->getCode();
        $reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
    unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);