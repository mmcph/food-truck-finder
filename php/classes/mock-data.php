<?php
use Edu\Cnm\FoodTruck\{
    Category, Favorite, Profile,Truck,TruckCategory,Vote
};


// grab the class under scrutiny
require_once(dirname(__DIR__) . "/classes/autoload.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

require_once("uuid.php");


//create profile objects and insert them into the data base

//profile 1
$password = "abc123";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile = new Profile(generateUuidV4(), bin2hex(random_bytes(16)),"g@yahoo.com", $hash, 1, G, Cordova, Gcordova);
$profile->insert($pdo);
echo "first profile";
var_dump($profile->getProfileId()->toString());

//profile 2
$password = "abc123";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile2 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)), "yvette@yahoo.com", $hash, "cats",1, Johnson);
$profile2->insert($pdo);
echo "second profile";
var_dump($profile2->getProfileId()->toString());

//profile 3
$password = "abc123";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile3 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)), "batman@yahoo.com", $hash, "meow", -1, Escobar);
$profile3->insert($pdo);
echo "third profile";
var_dump($profile3->getProfileId()->toString());











