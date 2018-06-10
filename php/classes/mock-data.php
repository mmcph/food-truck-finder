<?php
use Edu\Cnm\FoodTruck\{Category, Favorite, Profile,Truck,TruckCategory,Vote};


// grab the class under scrutiny
require_once(dirname(__DIR__) . "/classes/autoload.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");



//public function __construct($newProfileId, ?string $newProfileActivationToken, string $newProfileEmail, string $newProfileHash, int $newProfileIsOwner, string $newProfileFirstName, string $newProfileLastName, string $newProfileUserName) {



$profile = new Profile(generateUuidV4(),bin2hex(random_bytes(16)),"g@yahoo.com", "cows", 1, G, Cordova, Gcordova);

$profile2 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)), "yvette@yahoo.com", "cats",1, Johnson);



$profile = new Profile(generateUuidV4(),bin2hex(random_bytes(16)), "hope to figure this out3", "willy1@buller.com", "Willy", $HASH, "imageofimages3", "William", $SALT, "willster");
$profile->insert($pdo);
echo "first profile";
var_dump($profile->getProfileId()->toString());












$profile2->insert($pdo);
echo "second profile";
var_dump($profile2->getProfileId()->toString());
$password3 = "geewiz";
$SALT = bin2hex(random_bytes(32));
$HASH = hash_pbkdf2("sha512", $password, $SALT, 262144);
$profile3 = new Profile(generateUuidV4(), bin2hex(random_bytes(16)), "George Likes butterflies",
    "getsome@hotornot.com", "Manny", $HASH, "hootyhoo", "Momoney", $SALT, "Mr.Lictenstein");
$profile3->insert($pdo);
echo "third profile";
var_dump($profile3->getProfileId()->toString());
$eventId = generateUuidV4();
$event = new Event($eventId, $profile->getProfileId(),100,"chris' 10th birthday", "2022-11-04 19:45:32.4426", "babiesfirstparty", 35.084319, -106.619781, "get my big boy pants", 10, "2022-11-04 16:45:32.4426");
$event->insert($pdo);
echo "first Event";
var_dump($event->getEventId()->toString());
$eventId2 = generateUuidV4();
$event2 = new Event($eventId2, $profile->getProfileId(),2,"Dylans barn raising party!", "2022-11-22 23:45:32.4426", "Amish old folks", 46.084319, -146.619781, "build my venue", 1, "2022-11-22 06:45:32.4426");
$event2->insert($pdo);
echo "second Event";
var_dump($event2->getEventId()->toString());
$eventAttendanceId = generateUuidV4();
$eventAttendance = new EventAttendance($eventAttendanceId, $event->getEventId(),$profile->getProfileId(), true, 2);
$eventAttendance->insert($pdo);
echo "event Attendance";
var_dump($eventAttendance->getEventAttendanceId()->toString());
$eventAttendanceId1 = generateUuidV4();
$eventAttendance1 = new EventAttendance($eventAttendanceId1, $event2->getEventId(),$profile2->getProfileId(),  true, 1);
$eventAttendance1->insert($pdo);
echo "incorrect Event Attendance";
var_dump($eventAttendance1->getEventAttendanceId()->toString());
$eventAttendanceId2 = generateUuidV4();
$eventAttendance2 = new EventAttendance($eventAttendanceId2, $event->getEventId(), $profile3->getProfileId(), true, 1);
