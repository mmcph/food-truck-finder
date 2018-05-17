<?php
namespace Edu\Cnm\FoodTruck\Test;

use Edu\Cnm\FoodTruck\{Profile, Truck};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Truck class
 *
 * This is a complete PHPUnit test of the Truck class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Truck
 * @author Marlon McPherson <mmcpherson5@cnm.edu>
 **/
class TruckTest extends TacoTruckTest {
	/**
	 * Profile that created the Truck; this is for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;

	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH
	 */
	protected $VALID_PROFILE_HASH;

	/**
	 * id of the truck
	 * @var Uuid $VALID_TRUCKID
	 **/
	protected $VALID_TRUCKID = "dda3cc9b-8181-4dba-8c21-a855e7f98cf2";

	/**
	 * content of truck's bio
	 * @var string $VALID_TRUCKBIO
	 **/
	protected $VALID_TRUCKBIO = "We serve tacos";

	/**
	 * content of the updated truck bio
	 * @var string $VALID_TRUCKBIO2
	 **/
	protected $VALID_TRUCKBIO2 = "We serve tacos and burritos";

	/**
	 * content of truck is open
	 * @var int $VALID_TRUCKISOPEN
	 **/
	protected $VALID_TRUCKISOPEN = 1;

	/**
	 * content of the updated truck is open
	 * @var int $VALID_TRUCKISOPEN2
	 **/
	protected $VALID_TRUCKISOPEN2 = -1;

	/**
	 * content of truck latitude
	 * @var float $VALID_TRUCKLATITUDE
	 **/
	protected $VALID_TRUCKLATITUDE = 35.08599910;

	/**
	 * content of the updated truck latitude
	 * @var float $VALID_TRUCKLATITUDE2
	 **/
	protected $VALID_TRUCKLATITUDE2 = 36.12345678;

	/**
	 * content of truck longitude
	 * @var float $VALID_TRUCKLONGITUDE
	 **/
	protected $VALID_TRUCKLONGITUDE = -106.64991650;

	/**
	 * content of the updated truck longitude
	 * @var float $VALID_TRUCKLONGITUDE2
	 **/
	protected $VALID_TRUCKLONGITUDE2 = -107.12345678;

	/**
	 * content of truck name
	 * @var string $VALID_TRUCKNAME
	 **/
	protected $VALID_TRUCKNAME = "Froyo Baggins";

	/**
	 * content of the updated truck name
	 * @var string $VALID_TRUCKNAME2
	 **/
	protected $VALID_TRUCKNAME2 = "Sandwise Hamgee";

	/**
	 * content of truck phone
	 * @var string $VALID_TRUCKPHONE
	 **/
	protected $VALID_TRUCKPHONE = "15055555555";

	/**
	 * content of the updated truck phone
	 * @var string $VALID_TRUCKPHONE2
	 **/
	protected $VALID_TRUCKPHONE2 = "15055556666";

	/**
	 * content of truck url
	 * @var string $VALID_TRUCKURL
	 **/
	protected $VALID_TRUCKURL = "http://www.google.com";

	/**
	 * content of the updated truck url
	 * @var string $VALID_TRUCKURL2
	 **/
	protected $VALID_TRUCKURL2 = "http://www.yahoo.com";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

		// create and insert a Profile to own the test Truck
		$this->profile = new Profile (generateUuidV4(), "AUTHTOKENwqwqwqwqwqwqwqwqwqwqwqw", "test@phpunit.de", $this->VALID_PROFILE_HASH, 1, "php", "unit", "phpunit");
		$this->profile->insert($this->getPDO());

	}

	/**
	 * test inserting a valid Truck and verify that the actual mySQL data matches
	 **/
	public function testInsertValidTruck() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		// create a new Truck and insert to into mySQL
		$truckId = generateUuidV4();
		$truck = new Truck($truckId, $this->profile->getProfileId(), $this->VALID_TRUCKBIO, $this->VALID_TRUCKISOPEN, $this->VALID_TRUCKLATITUDE, $this->VALID_TRUCKLONGITUDE, $this->VALID_TRUCKNAME, $this->VALID_TRUCKPHONE, $this->VALID_TRUCKURL);
		$truck->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTruck = Truck::getTruckByTruckId($this->getPDO(), $truck->getTruckId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$this->assertEquals($pdoTruck->getTruckId(), $truckId);
		$this->assertEquals($pdoTruck->getTruckProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTruck->getTruckBio(), $this->VALID_TRUCKBIO);
		$this->assertEquals($pdoTruck->getTruckIsOpen(), $this->VALID_TRUCKISOPEN);
		$this->assertEquals($pdoTruck->getTruckLatitude(), $this->VALID_TRUCKLATITUDE);
		$this->assertEquals($pdoTruck->getTruckLongitude(), $this->VALID_TRUCKLONGITUDE);
		$this->assertEquals($pdoTruck->getTruckName(), $this->VALID_TRUCKNAME);
		$this->assertEquals($pdoTruck->getTruckPhone(), $this->VALID_TRUCKPHONE);
		$this->assertEquals($pdoTruck->getTruckUrl(), $this->VALID_TRUCKURL);
	}

	/**
	 * test inserting a Truck, editing it, and then updating it
	 **/
	public function testUpdateValidTruck() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		// create a new Truck and insert to into mySQL
		$truckId = generateUuidV4();
		$truck = new Truck($truckId, $this->profile->getProfileId(), $this->VALID_TRUCKBIO, $this->VALID_TRUCKISOPEN, $this->VALID_TRUCKLATITUDE, $this->VALID_TRUCKLONGITUDE, $this->VALID_TRUCKNAME, $this->VALID_TRUCKPHONE, $this->VALID_TRUCKURL);
		$truck->insert($this->getPDO());

		// edit the Truck and update it in mySQL
		$truck->setTruckBio($this->VALID_TRUCKBIO2);
		$truck->setTruckIsOpen($this->VALID_TRUCKISOPEN2);
		$truck->setTruckLatitude($this->VALID_TRUCKLATITUDE2);
		$truck->setTruckLongitude($this->VALID_TRUCKLONGITUDE2);
		$truck->setTruckName($this->VALID_TRUCKNAME2);
		$truck->setTruckPhone($this->VALID_TRUCKPHONE2);
		$truck->setTruckUrl($this->VALID_TRUCKURL2);
		$truck->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoTruck = Truck::getTruckByTruckId($this->getPDO(), $truck->getTruckId());
		$this->assertEquals($pdoTruck->getTruckId(), $truckId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$this->assertEquals($pdoTruck->getTruckProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTruck->getTruckBio(), $this->VALID_TRUCKBIO2);
		$this->assertEquals($pdoTruck->getTruckIsOpen(), $this->VALID_TRUCKISOPEN2);
		$this->assertEquals($pdoTruck->getTruckLatitude(), $this->VALID_TRUCKLATITUDE2);
		$this->assertEquals($pdoTruck->getTruckLongitude(), $this->VALID_TRUCKLONGITUDE2);
		$this->assertEquals($pdoTruck->getTruckName(), $this->VALID_TRUCKNAME2);
		$this->assertEquals($pdoTruck->getTruckPhone(), $this->VALID_TRUCKPHONE2);
		$this->assertEquals($pdoTruck->getTruckUrl(), $this->VALID_TRUCKURL2);
	}

	/**
	 * test creating a Truck and then deleting it
	 **/
	public function testDeleteValidTruck() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		// create a new Truck and insert to into mySQL
		$truckId = generateUuidV4();
		$truck = new Truck($truckId, $this->profile->getProfileId(), $this->VALID_TRUCKBIO, $this->VALID_TRUCKISOPEN, $this->VALID_TRUCKLATITUDE, $this->VALID_TRUCKLONGITUDE, $this->VALID_TRUCKNAME, $this->VALID_TRUCKPHONE, $this->VALID_TRUCKURL);
		$truck->insert($this->getPDO());

		// delete the Truck from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$truck->delete($this->getPDO());

		// grab the data from mySQL and enforce the Truck does not exist
		$pdoTruck = Truck::getTruckByTruckId($this->getPDO(), $truck->getTruckId());
		$this->assertNull($pdoTruck);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("truck"));
	}

	/**
	 * test grabbing a Truck that does not exist via truckId
	 **/
	public function testGetInvalidTruckByTruckId() : void {
		// grab a truck id that exceeds the maximum allowable truck id
		$truck = Truck::getTruckByTruckId($this->getPDO(), generateUuidV4());
		$this->assertNull($truck);
	}

	/**
	 * test inserting a Truck and regrabbing it from mySQL
	 **/
	public function testGetValidTruckByTruckProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		// create a new Truck and insert to into mySQL
		$truckId = generateUuidV4();
		$truck = new Truck($truckId, $this->profile->getProfileId(), $this->VALID_TRUCKBIO, $this->VALID_TRUCKISOPEN, $this->VALID_TRUCKLATITUDE, $this->VALID_TRUCKLONGITUDE, $this->VALID_TRUCKNAME, $this->VALID_TRUCKPHONE, $this->VALID_TRUCKURL);
		$truck->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Truck::getTruckByTruckProfileId($this->getPDO(), $truck->getTruckProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruck\\Truck", $results);

		// grab the result from the array and validate it
		$pdoTruck = $results[0];
		$this->assertEquals($pdoTruck->getTruckId(), $truckId);
		$this->assertEquals($pdoTruck->getTruckProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTruck->getTruckBio(), $this->VALID_TRUCKBIO);
		$this->assertEquals($pdoTruck->getTruckIsOpen(), $this->VALID_TRUCKISOPEN);
		$this->assertEquals($pdoTruck->getTruckLatitude(), $this->VALID_TRUCKLATITUDE);
		$this->assertEquals($pdoTruck->getTruckLongitude(), $this->VALID_TRUCKLONGITUDE);
		$this->assertEquals($pdoTruck->getTruckName(), $this->VALID_TRUCKNAME);
		$this->assertEquals($pdoTruck->getTruckPhone(), $this->VALID_TRUCKPHONE);
		$this->assertEquals($pdoTruck->getTruckUrl(), $this->VALID_TRUCKURL);

	}

	/**
	 * test grabbing a Truck that does not exist via truckProfileId
	 **/
	public function testGetInvalidTruckByTruckProfileId() : void {
		// grab a truck profile id that exceeds the maximum allowable truck profile id
		$truck = Truck::getTruckByTruckProfileId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $truck);
	}

	/**
	 * test grabbing a Truck by truckIsOpen
	 **/
	public function testGetValidTruckByTruckIsOpen() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		// create a new Truck and insert to into mySQL
		$truckId = generateUuidV4();
		$truck = new Truck($truckId, $this->profile->getProfileId(), $this->VALID_TRUCKBIO, $this->VALID_TRUCKISOPEN, $this->VALID_TRUCKLATITUDE, $this->VALID_TRUCKLONGITUDE, $this->VALID_TRUCKNAME, $this->VALID_TRUCKPHONE, $this->VALID_TRUCKURL);
		$truck->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Truck::getTruckByTruckIsOpen($this->getPDO(), $truck->getTruckIsOpen());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruck\\Truck", $results);

		// grab the result from the array and validate it
		$pdoTruck = $results[0];
		$this->assertEquals($pdoTruck->getTruckId(), $truckId);
		$this->assertEquals($pdoTruck->getTruckProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTruck->getTruckBio(), $this->VALID_TRUCKBIO);
		$this->assertEquals($pdoTruck->getTruckIsOpen(), $this->VALID_TRUCKISOPEN);
		$this->assertEquals($pdoTruck->getTruckLatitude(), $this->VALID_TRUCKLATITUDE);
		$this->assertEquals($pdoTruck->getTruckLongitude(), $this->VALID_TRUCKLONGITUDE);
		$this->assertEquals($pdoTruck->getTruckName(), $this->VALID_TRUCKNAME);
		$this->assertEquals($pdoTruck->getTruckPhone(), $this->VALID_TRUCKPHONE);
		$this->assertEquals($pdoTruck->getTruckUrl(), $this->VALID_TRUCKURL);

	}

	/**
	 * test grabbing a Truck by truckIsOpen that does not exist
	 **/
	public function testGetInvalidTruckByTruckIsOpen() : void {
		// grab a truck by truckIsOpen that does not exist
		$truck = Truck::getTruckByTruckIsOpen($this->getPDO(), 1);
		$this->assertCount(0, $truck);
	}

	/**
	 * test grabbing a Truck by truckName
	 **/
	public function testGetValidTruckByTruckName() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		// create a new Truck and insert to into mySQL
		$truckId = generateUuidV4();
		$truck = new Truck($truckId, $this->profile->getProfileId(), $this->VALID_TRUCKBIO, $this->VALID_TRUCKISOPEN, $this->VALID_TRUCKLATITUDE, $this->VALID_TRUCKLONGITUDE, $this->VALID_TRUCKNAME, $this->VALID_TRUCKPHONE, $this->VALID_TRUCKURL);
		$truck->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Truck::getTruckByTruckName($this->getPDO(), $truck->getTruckName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruck\\Truck", $results);

		// grab the result from the array and validate it
		$pdoTruck = $results[0];
		$this->assertEquals($pdoTruck->getTruckId(), $truckId);
		$this->assertEquals($pdoTruck->getTruckProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoTruck->getTruckBio(), $this->VALID_TRUCKBIO);
		$this->assertEquals($pdoTruck->getTruckIsOpen(), $this->VALID_TRUCKISOPEN);
		$this->assertEquals($pdoTruck->getTruckLatitude(), $this->VALID_TRUCKLATITUDE);
		$this->assertEquals($pdoTruck->getTruckLongitude(), $this->VALID_TRUCKLONGITUDE);
		$this->assertEquals($pdoTruck->getTruckName(), $this->VALID_TRUCKNAME);
		$this->assertEquals($pdoTruck->getTruckPhone(), $this->VALID_TRUCKPHONE);
		$this->assertEquals($pdoTruck->getTruckUrl(), $this->VALID_TRUCKURL);

	}

	/**
	 * test grabbing a Truck by truckName that does not exist
	 **/
	public function testGetInvalidTruckByTruckName() : void {
		// grab a truck by truckName that does not exist
		$truck = Truck::getTruckByTruckName($this->getPDO(), "Vegan Dirt Burgers");
		$this->assertCount(0, $truck);
	}

}