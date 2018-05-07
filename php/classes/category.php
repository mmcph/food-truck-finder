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
	public function __construct(integer $newCategoryId, string $newCategoryName) {
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
	public function setCategoryName($newCategoryName): void {
		if(is_string($newCategoryName) === false) {
			throw(new \TypeError("Input is not a string"));
		}

		if(strlen($newCategoryName) > 32 || empty($newCategoryName) === true) {
			throw(new \RangeException("category name empty or too large"));
		}
		// store new categoryName
		$this->categoryName = $newCategoryName;

	}



}