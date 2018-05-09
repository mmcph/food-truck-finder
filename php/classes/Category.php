<?php

namespace Edu\Cnm\FoodTruck;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

class category implements \JsonSerializable {

	/**
	 * id for this category; this is the primary key
	 * @var integer $categoryId
	 **/
	protected $categoryId;
	/**
	 * value attached to CategoryId
	 * @var string $categoryName
	 **/
	protected $categoryName;

	// CONSTRUCTOR

	/**
	 * constructor for category
	 *
	 * @param integer $newCategoryId id of this category or null if a new category
	 * @param string $newCategoryName
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(int $newCategoryId, string $newCategoryName) {
		try {
			$this->setCategoryId($newCategoryId);
			$this->setCategoryName($newCategoryName);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	// ACCESSORS AND MUTATORS

	/**
	 * accessor method for categoryId
	 *
	 * @return integer value of categoryId
	 **/
	public function getCategoryId(): int {
		return ($this->categoryId);
	}

	/**
	 * mutator method for categoryId
	 *
	 * @param int $newCategoryId new value of categoryId
	 * @throws \TypeError if $newCategoryId is not an integer
	 * @throws \RangeException if $newCategoryId too small OR too large OR empty string
	 **/
	public function setCategoryId($newCategoryId): void {
		if(is_int($newCategoryId) === false) {
			throw(new \TypeError("Input is not an integer"));
		}

		if($newCategoryId < 0 || $newCategoryId > 255 || empty($newCategoryId) === true) {
			throw(new \RangeException("CategoryId is not a value between 0 and 255"));
		}
		// store new categoryId
		$this->categoryId = $newCategoryId;

	}

	/**
	 * accessor method for categoryName
	 *
	 * @return string value of categoryName
	 **/
	public function getCategoryName(): string {
		return ($this->categoryName);
	}

	/**
	 * mutator method for categoryName
	 *
	 * @param string $newCategoryName new value of categoryName
	 * @throws \TypeError if $newCategoryName is not a string
	 * @throws \RangeException if $newCategoryName > 32chars OR empty string
	 **/
	public function setCategoryName(string $newCategoryName): void {
		// verify the token is secure
		$newCategoryName = trim($newCategoryName);
		$newCategoryName = filter_var($newCategoryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCategoryName) === true) {
			throw(new \InvalidArgumentException("Category name value is empty or insecure"));
		}

		if(strlen($newCategoryName) > 32) {
			throw(new \RangeException("category name too long"));
		}
		// store new categoryName
		$this->categoryName = $newCategoryName;

	}

	// PDO Methods

	/** inserts new category into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO category(categoryId, categoryName) VALUES(:categoryId, :categoryName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholders in the template
		$parameters = ["categoryId" => $this->categoryId, "categoryName" => $this->categoryName];
		$statement->execute($parameters);
	}

	/** deletes this category from mysql
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function delete(\PDO $pdo): void {

		// create query template
		$query = "DELETE FROM category WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);

		// bind member vars to placeholder in template
		$parameters = ["categoryId" => $this->categoryId];
		$statement->execute($parameters);
	}

	/** updates this category in mysql
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function update(\PDO $pdo): void {

		// create query template
		$query = "UPDATE category SET categoryName = :categoryName WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);

		$parameters = ["categoryId" => $this->categoryId, "categoryName" => $this->categoryName];
		$statement->execute($parameters);
	}

	/**
	 * gets the Category by categoryId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $categoryId category id to search for
	 * @return Category|null Category found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getCategoryByCategoryId(\PDO $pdo, $categoryId) : ?Category {
		// sanitize the categoryId before searching
		if(is_int($categoryId) === false) {
			throw(new \InvalidArgumentException("Category ID value is not an integer"));
		}

		// create query template
		$query = "SELECT categoryId, categoryName FROM category WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);

		// bind the category id to the place holder in the template
		$parameters = ["categoryId" => $categoryId];
		$statement->execute($parameters);

		// grab the category from mySQL
		try {
			$category = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$category = new Category($row["categoryId"], $row["categoryName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($category);
	}

	/**
	 * gets the Category by categoryName
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $categoryName category name to search for
	 * @return Category|null Category found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getCategoryByCategoryName(\PDO $pdo, $categoryName) : ?Category {
		// sanitize the categoryId before searching
		if(is_string($categoryName) === false) {
			throw(new \InvalidArgumentException("Category name value is not a string"));
		}

		// create query template
		$query = "SELECT categoryId, categoryName FROM category WHERE categoryName = :categoryName";
		$statement = $pdo->prepare($query);

		// bind the category id to the place holder in the template
		$parameters = ["categoryName" => $categoryName];
		$statement->execute($parameters);

		// grab the category from mySQL
		try {
			$category = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$category = new Category($row["categoryId"], $row["categoryName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($category);
	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		return($fields);
	}

}