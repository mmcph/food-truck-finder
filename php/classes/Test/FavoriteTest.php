<?php
namespace Edu\Cnm\FoodTruck\Test;

use Edu\Cnm\FoodTruck\{Profile, Truck, Favorite};

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
	 * @var Profile $profile
	 **/
	protected $profile;
	/**
	 * Truck that is favorited; this is for foreign key relations
	 * @var Truck $truck
	 **/
	protected $truck;
	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 **/
	private $VALID_HASH;
	/**
	 * valid activationToken to create the profile object to own the test
	 * @var string $VALID_ACTIVATION
	 **/
	private $VALID_ACTIVATION = null;
	/**
	 *
	 * create dependent objects before running each test
	 */
	public final function setUp(): void {
		
		// run the default setUp() method first
		parent::setUp();
		
		// create a hash for the mocked profile
		$password = "abc123";
		$this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		//$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
		
		// create and insert the mocked profile into mySQL
		$this->profile = new Profile (generateUuidV4(), $this->VALID_ACTIVATION,"php@gmail.com", $this->VALID_HASH,  1, "php", "unit", "phpunit");
		$this->profile->insert($this->getPDO());
		
		//create and insert the mocked truck
		$this->truck = new Truck (generateUuidV4(), $this->profile->getProfileId(), "I am a happy little truck.", 1, 35.0772, 106.6614, "LegenDairy", "5058596496", "https://phpunit.de/");
		$this->truck->insert($this->getPDO());
	}

    /**
     *
     * test inserting a valid favorite and verify that the actual mySQL data matches
     * @throws \Exception
     */
	public function testInsertFavorite(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		// create a new favorite and insert to into mySQL
		$favorite = new Favorite($this->truck->getTruckId(), $this->profile->getProfileId());
		$this->assertEquals($this->getConnection()->getRowCount("truck"), 1);
        var_dump($this->truck);
		$favorite->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteTruckIdAndFavoriteProfileId($this->getPDO(), $this->truck->getTruckId(), $this->profile->getProfileId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
        $this->assertEquals($pdoFavorite->getFavoriteTruckId(), $this->truck->getTruckId());
        $this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());

	}

    /**
     * @throws \Exception
     */

	public function testDeleteFavorite() : void {
		
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		
		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->truck->getTruckId(), $this->profile->getProfileId());
		$favorite->insert($this->getPDO());

		// delete the Favorite from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$favorite->delete($this->getPDO());

		// grab the data from mySQL and enforce the Truck does not exist
		$pdoFavorite = Favorite::getFavoriteByFavoriteTruckIdAndFavoriteProfileId($this->getPDO(), $this->profile->getProfileId(), $this->truck->getTruckId());
		$this->assertNull($pdoFavorite);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("favorite"));
	}


	public function testGetFavoriteByFavoriteTruckIdAndFavoriteProfileId() : void {
		
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		
		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->profile->getProfileId(), $this->truck->getTruckId());
		$favorite->insert($this->getPDO());
		
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoFavorite = Favorite::getFavoriteByFavoriteTruckIdAndFavoriteProfileId($this->getPDO(), $this->profile->getProfileId(), $this->truck->getTruckId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteTruckId(), $this->truck->getTruckId());
	}

	public function testGetInvalidFavoriteByFavoriteTruckIdAndFavoriteProfileId() {
		$favorite = Favorite::getFavoriteByFavoriteTruckIdAndFavoriteProfileId($this->getPDO(), generateUuidV4(), generateUuidV4());
		$this->assertNull($favorite);
	}

	public function testGetFavoriteByFavoriteTruckId() : void {
		
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		
		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite($this->truck->getTruckId(), $this->profile->getProfileId());
		$favorite->insert($this->getPDO());
		
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Favorite::getFavoriteByFavoriteTruckId($this->getPDO(), $this->truck->getTruckId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruck\\Favorite", $results);
		
		// grab the result from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteTruckId(), $this->profile->getTruckId());
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->truck->getProfileId());
	}

	public function testGetInvalidFavoriteByFavoriteTruckId() : void {

		// grab a truck id that exceeds the maximum allowable truck id
		$favorite = Favorite::getFavoriteByFavoriteTruckId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $favorite);
	}

	public function testGetFavoriteByProfileId() : void {
		
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		// create a new Favorite and insert to into mySQL
		$favorite = new Favorite( $this->truck->getTruckId(), $this->profile->getProfileId());
		$favorite->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Favorite::getFavoriteByFavoriteProfileId($this->getPDO(), $this->profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruck\\Favorite", $results);

		// grab the result from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteTruckId(), $this->truck->getTruckId());
        $this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
	}

	public function testGetInvalidFavoriteByProfileId() : void {

		$favorite = Favorite::getFavoriteByFavoriteProfileId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $favorite);
	}
}

