<?php
namespace Edu\Cnm\FoodTruck\Test;

use Edu\Cnm\FoodTruck\{
	Profile, Truck, Category, TruckCategory
};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the truck class
 *
 * This is a complete PHPUnit test of the truck class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Truck
 * @author Marlon McPherson <mmcpherson5@cnm.edu>
 **/
class TruckTest extends TacoTruckTest {
	/**
	 * Profile that created the truck; this is for foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;

	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_PROFILE_HASH
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
	protected $VALID_ACTIVATIONTOKEN = null;

	protected $category;
	protected $category0;
	protected $category1;
	protected $category2;
	protected $category3;
	protected $category4;
	protected $category5;
	protected $category6;
	protected $category7;
	protected $category8;
	protected $category9;

	protected $truck0;
	protected $truck1;
	protected $truck2;
	protected $truck3;
	protected $truck4;
	protected $truck5;
	protected $truck6;
	protected $truck7;
	protected $truck8;
	protected $truck9;

	protected $truckCategory0;
	protected $truckCategory1;
	protected $truckCategory2;
	protected $truckCategory3;
	protected $truckCategory4;
	protected $truckCategory5;
	protected $truckCategory6;
	protected $truckCategory7;
	protected $truckCategory8;
	protected $truckCategory9;


	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_PROFILE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);

		// create and insert a Profile to own the test truck
		$this->profile = new Profile (generateUuidV4(), $this->VALID_ACTIVATIONTOKEN, "test@phpunit.de", $this->VALID_PROFILE_HASH, 1, "php", "unit", "phpunit");
		$this->profile->insert($this->getPDO());


		$this->category = new Category(null, "cruddy Froyo");
		$this->category->insert($this->getPDO());

		$this->truck0 = new Truck(generateUuidV4(), generateUuidV4(), "bio", -1, 77.77777777, 77.77777777, "Truck Uno", "5055550001", "www.truckuno.com");
		$this->category->insert($this->getPDO());
		$this->truck1 = new Truck(generateUuidV4(), generateUuidV4(), "bio", -1, 77.77777777, 77.77777777, "Truck Dos", "5055550002", "www.truckdos.com");
		$this->category->insert($this->getPDO());
		$this->truck2 = new Truck(generateUuidV4(), generateUuidV4(), "bio", -1, 77.77777777, 77.77777777, "Truck Tres", "5055550003", "www.trucktres.com");
		$this->category->insert($this->getPDO());
		$this->truck3 = new Truck(generateUuidV4(), generateUuidV4(), "bio", -1, 77.77777777, 77.77777777, "Truck Cuatro", "5055550004", "www.truckcuatro.com");
		$this->category->insert($this->getPDO());
		$this->truck4 = new Truck(generateUuidV4(), generateUuidV4(), "bio", -1, 77.77777777, 77.77777777, "Truck Cinco", "5055550005", "www.truckcinco.com");
		$this->category->insert($this->getPDO());
		$this->truck5 = new Truck(generateUuidV4(), generateUuidV4(), "bio", -1, 77.77777777, 77.77777777, "Truck Seis", "5055550006", "www.truckseis.com");
		$this->category->insert($this->getPDO());
		$this->truck6 = new Truck(generateUuidV4(), generateUuidV4(), "bio", -1, 77.77777777, 77.77777777, "Truck Siete", "5055550007", "www.trucksiete.com");
		$this->category->insert($this->getPDO());
		$this->truck7 = new Truck(generateUuidV4(), generateUuidV4(), "bio", -1, 77.77777777, 77.77777777, "Truck Ocho", "5055550008", "www.truckocho.com");
		$this->category->insert($this->getPDO());
		$this->truck8 = new Truck(generateUuidV4(), generateUuidV4(), "bio", -1, 77.77777777, 77.77777777, "Truck Nueve", "5055550009", "www.trucknueve.com");
		$this->category->insert($this->getPDO());
		$this->truck9 = new Truck(generateUuidV4(), generateUuidV4(), "bio", -1, 77.77777777, 77.77777777, "Truck Diez", "5055550010", "www.truckdiez.com");
		$this->category->insert($this->getPDO());
		$this->category0 = new Category(null, "New Mexican");
		$this->category->insert($this->getPDO());
		$this->category1 = new Category(null, "Mexican");
		$this->category->insert($this->getPDO());
		$this->category2 = new Category(null, "Chinese");
		$this->category->insert($this->getPDO());
		$this->category3 = new Category(null, "Burritos");
		$this->category->insert($this->getPDO());
		$this->category4 = new Category(null, "Tacos");
		$this->category->insert($this->getPDO());
		$this->category5 = new Category(null, "Chicharrones");
		$this->category->insert($this->getPDO());
		$this->category6 = new Category(null, "Vegan");
		$this->category->insert($this->getPDO());
		$this->category7 = new Category(null, "Vegetarian");
		$this->category->insert($this->getPDO());
		$this->category8 = new Category(null, "Pescetarian");
		$this->category->insert($this->getPDO());
		$this->category9 = new Category(null, "Breatharian");
		$this->category->insert($this->getPDO());
		$this->truckCategory0 = new TruckCategory(null, generateUuidV4());
		$this->category->insert($this->getPDO());
		$this->truckCategory1 = new TruckCategory(null, generateUuidV4());
		$this->category->insert($this->getPDO());
		$this->truckCategory2 = new TruckCategory(null, generateUuidV4());
		$this->category->insert($this->getPDO());
		$this->truckCategory3 = new TruckCategory(null, generateUuidV4());
		$this->category->insert($this->getPDO());
		$this->truckCategory4 = new TruckCategory(null, generateUuidV4());
		$this->category->insert($this->getPDO());
		$this->truckCategory5 = new TruckCategory(null, generateUuidV4());
		$this->category->insert($this->getPDO());
		$this->truckCategory6 = new TruckCategory(null, generateUuidV4());
		$this->category->insert($this->getPDO());
		$this->truckCategory7 = new TruckCategory(null, generateUuidV4());
		$this->category->insert($this->getPDO());
		$this->truckCategory8 = new TruckCategory(null, generateUuidV4());
		$this->category->insert($this->getPDO());
		$this->truckCategory9 = new TruckCategory(null, generateUuidV4());
		$this->category->insert($this->getPDO());
	}

	/**
	 * test inserting a valid truck and verify that the actual mySQL data matches
	 **/
	public function testInsertValidTruck() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		// create a new truck and insert to into mySQL
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
	 * test inserting a truck, editing it, and then updating it
	 **/
	public function testUpdateValidTruck() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		// create a new truck and insert to into mySQL
		$truckId = generateUuidV4();
		$truck = new Truck($truckId, $this->profile->getProfileId(), $this->VALID_TRUCKBIO, $this->VALID_TRUCKISOPEN, $this->VALID_TRUCKLATITUDE, $this->VALID_TRUCKLONGITUDE, $this->VALID_TRUCKNAME, $this->VALID_TRUCKPHONE, $this->VALID_TRUCKURL);
		$truck->insert($this->getPDO());

		// edit the truck and update it in mySQL
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
	 * test creating a truck and then deleting it
	 **/
	public function testDeleteValidTruck() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		// create a new truck and insert to into mySQL
		$truckId = generateUuidV4();
		$truck = new Truck($truckId, $this->profile->getProfileId(), $this->VALID_TRUCKBIO, $this->VALID_TRUCKISOPEN, $this->VALID_TRUCKLATITUDE, $this->VALID_TRUCKLONGITUDE, $this->VALID_TRUCKNAME, $this->VALID_TRUCKPHONE, $this->VALID_TRUCKURL);
		$truck->insert($this->getPDO());

		// delete the truck from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$truck->delete($this->getPDO());

		// grab the data from mySQL and enforce the truck does not exist
		$pdoTruck = Truck::getTruckByTruckId($this->getPDO(), $truck->getTruckId());
		$this->assertNull($pdoTruck);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("truck"));
	}

	/**
	 * test grabbing a truck that does not exist via truckId
	 **/
	public function testGetInvalidTruckByTruckId() : void {
		// grab a truck id that exceeds the maximum allowable truck id
		$truck = Truck::getTruckByTruckId($this->getPDO(), generateUuidV4());
		$this->assertNull($truck);
	}

	/**
	 * test inserting a truck and regrabbing it from mySQL
	 **/
	public function testGetValidTruckByTruckProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		// create a new truck and insert to into mySQL
		$truckId = generateUuidV4();
		$truck = new Truck($truckId, $this->profile->getProfileId(), $this->VALID_TRUCKBIO, $this->VALID_TRUCKISOPEN, $this->VALID_TRUCKLATITUDE, $this->VALID_TRUCKLONGITUDE, $this->VALID_TRUCKNAME, $this->VALID_TRUCKPHONE, $this->VALID_TRUCKURL);
		$truck->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Truck::getTruckByTruckProfileId($this->getPDO(), $truck->getTruckProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruck\\truck", $results);

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
	 * test grabbing a truck that does not exist via truckProfileId
	 **/
	public function testGetInvalidTruckByTruckProfileId() : void {
		// grab a truck profile id that exceeds the maximum allowable truck profile id
		$truck = Truck::getTruckByTruckProfileId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $truck);
	}

	/**
	 * test grabbing a truck by truckIsOpen
	 **/
	public function testGetValidTruckByTruckIsOpen() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		// create a new truck and insert to into mySQL
		$truckId = generateUuidV4();
		$truck = new Truck($truckId, $this->profile->getProfileId(), $this->VALID_TRUCKBIO, $this->VALID_TRUCKISOPEN, $this->VALID_TRUCKLATITUDE, $this->VALID_TRUCKLONGITUDE, $this->VALID_TRUCKNAME, $this->VALID_TRUCKPHONE, $this->VALID_TRUCKURL);
		$truck->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Truck::getTruckByTruckIsOpen($this->getPDO(), $truck->getTruckIsOpen());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruck\\truck", $results);

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
	 * test grabbing a truck by truckIsOpen that does not exist
	 **/
	public function testGetInvalidTruckByTruckIsOpen() : void {
		// grab a truck by truckIsOpen that does not exist
		$truck = Truck::getTruckByTruckIsOpen($this->getPDO(), 1);
		$this->assertCount(0, $truck);
	}

	/**
	 * test grabbing a truck by truckName
	 **/
	public function testGetValidTruckByTruckName() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("truck");

		// create a new truck and insert to into mySQL
		$truckId = generateUuidV4();
		$truck = new Truck($truckId, $this->profile->getProfileId(), $this->VALID_TRUCKBIO, $this->VALID_TRUCKISOPEN, $this->VALID_TRUCKLATITUDE, $this->VALID_TRUCKLONGITUDE, $this->VALID_TRUCKNAME, $this->VALID_TRUCKPHONE, $this->VALID_TRUCKURL);
		$truck->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Truck::getTruckByTruckName($this->getPDO(), $truck->getTruckName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truck"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruck\\truck", $results);

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


		$truckCategory = new TruckCategory($this->category->getCategoryId(), $truck->getTruckId());
		$truckCategory->insert($this->getPDO());

		$tempTruck =  Truck::getTrucksAndCategoryNamesByTruckCategoryCategoryId($this->getPDO(), [$this->category->getCategoryId()]);

	}

	/**
	 * test grabbing a truck by truckName that does not exist
	 **/
	public function testGetInvalidTruckByTruckName() : void {
		// grab a truck by truckName that does not exist
		$truck = Truck::getTruckByTruckName($this->getPDO(), "Vegan Dirt Burgers");
		$this->assertCount(0, $truck);


	}

}