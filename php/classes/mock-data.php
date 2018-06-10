<?php
use Edu\Cnm\FoodTruck\{
    Category, Favorite, Profile,Truck,TruckCategory,Vote
};


// grab the class under scrutiny
require_once(dirname(__DIR__) . "/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");


require_once (dirname(__DIR__, 1) . "/lib/uuid.php");


$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/foodtruck.ini");


//create profile objects and insert them into the data base


//profile 1
$password = "abc123";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile1 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)),"g@yahoo.com", $hash, "1", "G", "Cordova", "Gcordova");
$profile1 -> insert ($pdo);
echo "first profile";
var_dump($profile1->getProfileId()->toString());

//profile 2
$password = "abc123";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile2 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)), "yvette@yahoo.com", $hash, "1", "Yvette", "Johnson", "yjohnson6");
$profile2->insert($pdo);
echo "second profile";
var_dump($profile2->getProfileId()->toString());

//profile 3
$password = "abc123";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile3 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)), "batman@yahoo.com", $hash, "-1", "Batman", "Escobar", "batmanforever");
$profile3->insert($pdo);
echo "third profile";
var_dump($profile3->getProfileId()->toString());

$truck1 = new Truck(generateUuidV4(), $profile1->getProfileId(), "stuff about this truck", 1, 4.4,1.7, "taco tuesday truck", "505-987-6547", "tacotruck.com");
$truck1->insert($pdo);
echo "1st profile";

$truck2 = new Truck(generateUuidV4(), $profile2->getProfileId(), "more stuff about this truck", 1, 7.4,7.7, "marios pizza truck", "505-987-5447", "pizzatruck.com");
$truck2->insert($pdo);
echo "second profile";

$truck3 = new Truck(generateUuidV4(), $profile3->getProfileId(), " random stuff about this truck", 1, 6.4,9.7, "dereks pizza truck", "505-987-5227", "derekspizzatruck.com");
$truck3->insert($pdo);
echo "3rd profile";

// categories dummy data
$category1 = new Category(4, "New Mexican");
$category1->insert($pdo);
echo "first profile";

$category2 = new Category(5, "Mexican");
$category2->insert($pdo);
echo "second category";

$category3 = new Category(6, "dessert");
$category3->insert($pdo);
echo "3rd category";

// vote dummy data
$vote1 = new Vote($profile1->getProfileId(), $truck1->getTruckId(), 1);
$vote1->insert($pdo);
echo "1st vote";

$vote2 = new Vote($profile1->getProfileId(), $truck2->getTruckId(), -1);
$vote2->insert($pdo);
echo "2nd vote";

$vote3 = new Vote($profile2->getProfileId(), $truck1->getTruckId(), 1);
$vote3->insert($pdo);
echo "3rd vote";

// favorite dummy data
$favorite1 = new Favorite($profile1->getProfileId(), $truck1->getTruckId());
$favorite1->insert($pdo);
echo "first favorite";

$favorite2 = new Favorite ($profile1->getProfileId(), $truck2->getTruckId());
$favorite2->insert($pdo);
echo "2nd favorite";

$favorite3 = new Favorite($profile2->getProfileId(), $truck1->getTruckId());
$favorite3->insert($pdo);
echo "3rd favorite";






