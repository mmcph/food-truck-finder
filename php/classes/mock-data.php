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



$password = "password";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile1 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)),"q@gmail.com", $hash, "1", "Q", "Qordova", "Qcordova");
$profile1 -> insert ($pdo);
echo "first profile";
var_dump($profile1->getProfileId()->toString());
//

$password = "password";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile2 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)), "yvette@gmail.com", $hash, "1", "Yvette", "Johnson", "yjohnson6");
$profile2->insert($pdo);
echo "second profile";
var_dump($profile2->getProfileId()->toString());
//

$password = "password";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile3 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)), "batman@gmail.com", $hash, "1", "Batman", "Escobar", "BatmanForever");
$profile3->insert($pdo);
echo "third profile";
var_dump($profile3->getProfileId()->toString());


$password = "password";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile4 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)), "marlon@gmail.com", $hash, "1", "Marlon", "McPherson", "MMCPH");
$profile4 -> insert ($pdo);
echo "fourth profile";
var_dump($profile4->getProfileId()->toString());


$password = "password";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile5 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)),"bobby@gmail.com", $hash, "1", "Bobby", "Tables", "Bobby");
$profile5 -> insert ($pdo);
echo "fifth profile";
var_dump($profile5->getProfileId()->toString());


$password = "password";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile6 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)),"bill@gmail.com", $hash, "1", "Bill", "Johnson", "Winston");
$profile6 -> insert ($pdo);
echo "sixth profile";
var_dump($profile6->getProfileId()->toString());



$password = "password";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile7 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)),"maria@gmail.com", $hash, "1", "Maria", "Escobar", "Maria1");
$profile7 -> insert ($pdo);
echo "7th profile";
var_dump($profile7->getProfileId()->toString());



$password = "password";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
$profile8 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)),"g@gmail.com", $hash, "-1", "G", "Cordova", "Gcordova");
$profile8 -> insert ($pdo);
echo "8th profile - customer";
var_dump($profile8->getProfileId()->toString());



$truck1 = new Truck(generateUuidV4(), $profile1->getProfileId(), "We offer fresh local coffee, espresso, mocha and lattes. Get your cup of Joe on the Go!", 1, 35.0808167,-106.6085792, "Green Joe Coffee Truck", "Phone: 505-545-3555", "www.test.com");
$truck1->insert($pdo);
echo "1st truck";
var_dump($truck1->getTruckId()->toString());


$truck2 = new Truck(generateUuidV4(), $profile2->getProfileId(), "The Supper Truck’s recipe for success is simple: start with fresh, local ingredients, prepare them in a timely manner and be consistent every time.", 1, 35.0927633,-106.6467412, "The Supper Truck", "Phone: 505.796.2181", "www.test.com");
$truck2->insert($pdo);
echo "second truck";
var_dump($truck2->getTruckId()->toString());
//
$truck3= new Truck(generateUuidV4(), $profile3->getProfileId(), "We serve many types of tacos, including carne adovada, carnitas, chicken and more - stop by and try some out!", 1, 35.0842589,-106.6942458, "Taco Bus", "Phone: (505) 301-7512", "www.taco.com");
$truck3->insert($pdo);
echo "3rd truck";
var_dump($truck3->getTruckId()->toString());

$truck4 = new Truck(generateUuidV4(), $profile4->getProfileId(), "Caribbean, southern comfort, and traditional Portuguese/Italian", 1, 35.1178114, -106.6163057, "My Sweet Basil", "Phone: (505) 417-9840", "http://www.soulaina.com/");
$truck4->insert($pdo);
echo "4th truck";
var_dump($truck4->getTruckId()->toString());




$truck5= new Truck(generateUuidV4(), $profile5->getProfileId(), "Pulled Pork Sandwhiches", 1, 35.1562086, -106.5981825 , "Gedunk Truck", "Phone: (505) 315-3521", "http://www.google.com");
$truck5->insert($pdo);
echo "5th truck";
var_dump($truck5->getTruckId()->toString());


$truck6= new Truck(generateUuidV4(), $profile6->getProfileId(), "Caribbean, southern comfort, and traditional Portuguese/Italian", 1, 35.1178114, -106.6163057, "My Sweet Basil", "Phone: (505) 417-9840", "http://www.google.com/");
$truck6->insert($pdo);
echo "6th truck";
var_dump($truck6->getTruckId()->toString());


$truck7= new Truck(generateUuidV4(), $profile7->getProfileId(), "Caribbean
outhern comfort, and traditional Portuguese/Italian", 1, 35.1178114, -106.6163057, "My Sweet Basil", "Phone: (505) 417-9840", "http://www.google.com/");
$truck7->insert($pdo);
echo "7th truck";
var_dump($truck7->getTruckId()->toString());






//// vote dummy data
$vote1 = new Vote($profile8->getProfileId(), $truck1->getTruckId(), 1);
$vote1->insert($pdo);
echo "1st vote";

$vote2 = new Vote($profile8->getProfileId(), $truck2->getTruckId(), 1);
$vote2->insert($pdo);
echo "2nd vote";

$vote3 = new Vote($profile8->getProfileId(), $truck3->getTruckId(), 1);
$vote3->insert($pdo);
echo "3rd vote";
$vote4 = new Vote($profile8->getProfileId(), $truck4->getTruckId(), -1);



////// favorite dummy data
$favorite1 = new Favorite($profile8->getProfileId(), $truck1->getTruckId());
$favorite1->insert($pdo);
echo "first favorite";

$favorite2 = new Favorite ($profile8->getProfileId(), $truck2->getTruckId());
$favorite2->insert($pdo);
echo "2nd favorite";

$favorite3 = new Favorite($profile8->getProfileId(), $truck3->getTruckId());
$favorite3->insert($pdo);
echo "3rd favorite";



// truck category mock-data - need to be updated with new UUID



$truckCategory1 = new TruckCategory(13, $truck1->getTruckId());
$truckCategory1->insert($pdo);
echo "truck category";

$truckCategory2 = new TruckCategory(5,$truck2->getTruckId());
$truckCategory2->insert($pdo);
echo "truck category";


$truckCategory3 = new TruckCategory(64,$truck3->getTruckId());
$truckCategory3->insert($pdo);
echo "truck category";

