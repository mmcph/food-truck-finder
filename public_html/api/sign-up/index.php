<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Foodtruck\Profile;


/**
 * api for signing up for FoodTruck Finder
 * @author Yvette itsyvejr@gmail.com
 */

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

//prepare  an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data=null;

try {
    // grab the mySQL connection
    $pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/foodtruck.ini");\

    // determine which HTTP method was used
    $method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


    if($method === "POST") {

        //decode the json and turn it into a php object
        $requestContent = file_get_contents("php://input");
        $requestObject = json_decode($requestContent);

        // isOwner is a required field
        if(empty($requestObject->profileIsOwner) === true){
            throw(new \InvalidArgumentException("'Is owner' is a required field", 405));
        }

        // first name is a required field
        if(empty($requestObject->profileFirstName) === true) {
            throw(new \InvalidArgumentException ("Must input first name", 405));
        }

        // last name is a required field
        if(empty($requestObject->profileLastName) === true) {
            throw(new \InvalidArgumentException ("Must input last name", 405));
        }

        //profile username is a required field
        if(empty($requestObject->profileUserName) === true) {
            throw(new \InvalidArgumentException ("No profile username", 405));
        }

        //profile email is a required field
        if(empty($requestObject->profileEmail) === true) {
            throw(new \InvalidArgumentException ("No profile email present", 405));
        }

        //verify that profile password is present
        if(empty($requestObject->profilePassword) === true) {
            throw(new \InvalidArgumentException ("Must input valid password", 405));
        }

        //verify that the confirm password is present
        if(empty($requestObject->profilePasswordConfirm) === true) {
            throw(new \InvalidArgumentException ("Must input valid password", 405));
        }

        //make sure the password and confirm password match
        if ($requestObject->profilePassword !== $requestObject->profilePasswordConfirm) {
            throw(new \InvalidArgumentException("passwords do not match"));
        }

        $hash = password_hash($requestObject->profilePassword, PASSWORD_ARGON2I, ["time_cost" => 384]);
        $profileActivationToken = bin2hex(random_bytes(16));

        //create the profile object and prepare to insert into the database
        $profile = new Profile(generateUuidV4(), $profileActivationToken, $requestObject->profileEmail, $hash, $requestObject->profileIsOwner, $requestObject->profileFirstName, $requestObject->profileLastName. $requestObject->profileUserName);

        //insert the profile into the database
        $profile->insert($pdo);

        //compose the email message to send with th activation token
        $messageSubject = "Please check your email to complete your account activation.";

        //make sure URL is /public_html/api/        //building the activation link that can travel to another server and still work. This is the link that will be clicked to confirm the account.activation/$activation
        $basePath = dirname($_SERVER["SCRIPT_NAME"], 3);
        //create the path
        $urlglue = $basePath . "/api/activation/?activation=" . $profileActivationToken;
        //create the redirect link
        $confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
        //compose message to send with email
        $message = <<< EOF

} else {
    throw (new InvalidArgumentException("invalid http request"));
EOF;
