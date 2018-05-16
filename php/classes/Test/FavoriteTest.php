<?php
namespace Edu\Cnm\FoodTruck\Test;

use Edu\Cnm\FoodTruck\{Profile, Truck};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Favorite class
 *
 * This is a complete PHPUnit test of the Favorite class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Favorite
 * @author Marlon McPherson <mmcpherson5@cnm.edu>
 **/
class FavoriteTest extends TacoTruckTest {
	/**
	 * Profile that created the Favorite; this is for foreign key relations
	 * @var Profile
	 **/
	protected $profile = null;
	/**
	 * Truck that is favorited; this is for foreign key relations
	 * var Truck
	 **/
	protected $truck = null;


}