<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\FoodTruck\{
    Profile, Truck, Vote
//todo does this look right?
};
/**
 * api for the Vote class
 *
 * @author Yvette Johnson-Rodgers <itsyvejr@gmail.com>
 **/

// verify the session; start the session start if not active
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
    //todo this is not the correct .ini

    //determine which HTTP method was used
    $method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

    //sanitize input
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
    $voteProfileId = filter_input(INPUT_GET, "voteProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $voteTruckId = filter_input(INPUT_GET, "voteTruckId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $voteValue = filter_input(INPUT_GET, "voteValue", FILTER_VALIDATE_INT, FILTER_FLAG_ENCODE_LOW);
    //todo I am guessing on the voteValue on the filter statements

    //make sure the id is valid for methods that require it
    if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
        throw(new InvalidArgumentException("id cannot be empty or negative", 405));
    }
