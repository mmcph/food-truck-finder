<?php
namespace Edu\Cnm\FoodTruck\Test;
use Edu\Cnm\FoodTruck\{Vote, Profile, Truck};
use function Sodium\randombytes_random16;
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");
// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
/**
 * Full PHPUnit test for the Vote class
 *
 * This is a complete PHPUnit test of the Vote class. It is complete because it tests all mySQL/PDO enabled methods
 * for both valid and invalid inputs
 *
 * @see Vote
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 *
 **/