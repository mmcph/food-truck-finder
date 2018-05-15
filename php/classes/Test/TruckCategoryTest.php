<?php
namespace Edu\Cnm\FoodTruck\Test;

use Edu\Cnm\FoodTruck\{Truck, Category, TruckCategory};
sodium_add();

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
// might not need

/**
 * Full PHPUnit test for the TruckCategory class
 *
 * This is a complete PHPUnit test of the TruckCategory class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see TruckCategory
 * @author Manuel L Escobar III <manuel.esco.20@gmail.com>
 **/
class TruckCategoryTest extends TacoTruckTest {


	/**
	 * profile that has the TruckCategory
	 * @var
	 */
	private $profile = null;


	/**
	 *truck that has a TruckCategory
	 * @var
	 */
	private $truck = null;


	/**
	 * category that has the TruckCategory
	 * @var
	 */
	private $category = null;

	/**
	 *
	 * create dependent objects before running each test
	 */
	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();

		// create and insert the mocked profile into mySQL
		$this->profile = new Profile (generateUuidV4(), "test@phpunit.de", $this->VALID_HASH, 1, "php", "unit", "phpunit");
		$this->profile->insert($this->getPDO());

		//create and insert the mocked truck
		$truckId = generateUuidV4();
		$this->truck = new Truck ($truckId, $this->profile->getProfileId(), "I am a happy little truck.", 1, 35.0772, 106.6614, "LegenDairy", 5058596496, "https://phpunit.de/");
		$this->truck->insert($this->getPDO());

		//create and insert the mocked Category
		$categoryId = 7;
		$this->category = new Category ($categoryId, "pizza pie");
		$this->category->insert($this->getPDO());
	}


	public function testInsertValidTruckCategory(): void {
		//counts the number of rows and save's it for later
		$numRows = $this->getConnection()->getRowCount("truckCategory");

		// create a new TruckCategory and insert to into mySQL
		$truckCategory = new TruckCategory(7, $this->truck->getTruckId());
		$truckCategory->insert($this->getPDO());

// grab the data from mySQL and enforce the fields match our expectations
		$pdoTruckCategory = TruckCategory::getTruckCategoryByTruckCategoryCategoryIdAndTruckCategoryTruckId($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truckCategory"));
		$this->assertEquals($pdoTruckCategory->getTruckCategoryCategoryId(), $this->truckCategoryCategoryId->getCategoryCategoryId());
		$this->assertEquals($pdoTruckCategory->getTruckCategoryTruckId(), $this->truckCategoryTruckId->getCategoryTruckId());


	public function testDeleteValidTruckCategory(): void {
		//counts the number of rows and save's it for later
		$numRows = $this->getConnection()->getRowCount("truckCategory");

		// create a new TruckCategory and insert to into mySQL
		$truckCategory = new TruckCategory(7, $this->truck->getTruckId());
		$truckCategory->insert($this->getPDO());

		//delete the TruckCategory from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truckCategory"));
		$truckCategory->delete($this->getPDO());

// grab the data from mySQL and enforce the fields match our expectations
		$pdoTruckCategory = TruckCategory::getTruckCategoryByTruckCategoryCategoryIdAndTruckCategoryTruckId($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truckCategory"));
		$this->assertEquals($pdoTruckCategory->getTruckCategoryCategoryId(), $this->truckCategoryCategoryId->getCategoryCategoryId());
		$this->assertEquals($pdoTruckCategory->getTruckCategoryTruckId(), $this->truckCategoryTruckId->getCategoryTruckId());
	}
}



public function getValidTruckCategoryByTruckCategoryCategoryIdAndTruckCategoryTruckId(): void {
	//counts the number of rows and saves it for later
	$numRows = $this->getConnection()->getRowCount("truckCategory");

	// create a new TruckCategory and insert to into mySQL
	$truckCategory = new TruckCategory(7, $this->truck->getTruckId());
	$truckCategory->insert($this->getPDO());

// grab the data from mySQL and enforce the fields match our expectations
	$pdoTruckCategory = TruckCategory::getTruckCategoryByTruckCategoryCategoryIdAndTruckCategoryTruckId($this->getPDO());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("truckCategory"));
	$this->assertEquals($pdoTruckCategory->getTruckCategoryCategoryId(), $this->truckCategoryCategoryId->getCategoryCategoryId());
	$this->assertEquals($pdoTruckCategory->getTruckCategoryTruckId(), $this->truckCategoryTruckId->getCategoryTruckId());
	}
}





