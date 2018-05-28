<?php
namespace Edu\Cnm\FoodTruck\Test;

use Edu\Cnm\FoodTruck\Category;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the category class
 *
 * This is a complete PHPUnit test of the category class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Category
 * @author Marlon McPherson <mmcpherson5@cnm.edu>
 **/
class CategoryTest extends TacoTruckTest {

	/**
	 * ID for this category; created in mySQL via enumeration
	 * @var int $VALID_CATEGORYID
	 **/
	protected $VALID_CATEGORYID = null;

	/**
	 * Name for this category
	 * @var string $VALID_CATEGORYNAME
	 **/
	protected $VALID_CATEGORYNAME = "Mexican";

	/**
	 * Updated Name for this category
	 * @var string $VALID_CATEGORYNAME2
	 **/
	protected $VALID_CATEGORYNAME2 = "New Mexican";

	/**
	 * test inserting a valid category and verify that the actual mySQL data matches
	 **/

	public function testInsertValidCategory() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");

		// create a new category and insert to into mySQL
		$category = new Category(null, $this->VALID_CATEGORYNAME);
		$category->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations

		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryId(), $category->getCategoryId());
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORYNAME);
	}

	/**
	 * test creating a category and then deleting it
	 **/
	public function testDeleteValidCategory() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");

		// create a new category and insert to into mySQL
		$category = new Category(null, $this->VALID_CATEGORYNAME);
		$category->insert($this->getPDO());

		// delete the category from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$category->delete($this->getPDO());

		// grab the data from mySQL and enforce the category does not exist
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertNull($pdoCategory);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("category"));
	}

	/**
	 * test grabbing a category that does not exist (via categoryId)
	 **/
	public function testGetInvalidCategoryByCategoryId() : void {
		// grab a category id that exceeds the maximum allowable category id
		$category = Category::getCategoryByCategoryId($this->getPDO(), 256);
		$this->assertNull($category);
	}

	/**
	 * test grabbing a category that does not exist (via categoryName)
	 **/
	public function testGetInvalidCategoryByCategoryName() : void {
		// grab a category name that does not exist (though the standards to which some food trucks hold themselves may relegate them to this particular category)
		$category = Category::getCategoryByCategoryName($this->getPDO(), "Dog Food");
		//$this->assertCount(0, $category);
        $this->assertNull($category);
	}

	/**
	 * test grabbing all Categories
	 **/
	public function testGetAllValidCategories() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");

		// create a new category and insert to into mySQL
		$category = new Category(null, $this->VALID_CATEGORYNAME);
		$category->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Category::getAllCategories($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruck\\category", $results);

		// grab the result from the array and validate it
		$pdoCategory = $results[0];
		$this->assertEquals($pdoCategory->getCategoryId(), $category->getCategoryId());
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORYNAME);
	}
}