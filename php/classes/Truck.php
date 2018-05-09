<?php

namespace Edu\Cnm\FoodTruck;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class truck implements \JsonSerializable {

	use ValidateUuid;

	/**
	 * id for this truck; this is the primary key
	 * @var Uuid $truckId
	 **/
	protected $truckId;
	/**
	 * profileId associated with this truck
	 * @var Uuid $truckProfileId
	 **/
	protected $truckProfileId;
	/**
	 * Bio for this truck
	 * @var string $truckBio
	 **/
	protected $truckBio;
	/**
	 * boolean int to track whether truck is open
	 * @var int $truckIsOpen - 1=open, 0=closed
	 **/
	protected $truckIsOpen;
	/**
	 * latitudinal coord for truck location
	 * @var float $truckLatitude
	 **/
	protected $truckLatitude;
	/**
	 * longitudinal coord for truck location
	 * @var float $truckLongitude
	 **/
	protected $truckLongitude;
	/**
	 * name of this food truck
	 * @var string $truckName
	 **/
	protected $truckName;
	/**
	 * phone number for this truck
	 * @var int $truckPhone
	 **/
	protected $truckPhone;
	/**
	 * URL for this truck
	 * @var string $truckUrl
	 **/
	protected $truckUrl;

	// CONSTRUCTOR

	/**
	 * constructor for truck
	 *
	 * @param Uuid $newTruckId id of this Truck or null if a new Truck
	 * @param Uuid $newTruckProfileId
	 * @param string $newTruckBio
	 * @param int $newTruckIsOpen
	 * @param float $newTruckLatitude
	 * @param float $newTruckLongitude
	 * @param string $newTruckName
	 * @param int $newTruckPhone
	 * @param string $newTruckUrl
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(Uuid $newTruckId, Uuid $newTruckProfileId, string $newTruckBio, int $newTruckIsOpen, float $newTruckLatitude, float $newTruckLongitude, string $newTruckName, int $newTruckPhone, string $newTruckUrl) {
		try {
			$this->setTruckId($newTruckId);
			$this->setTruckProfileId($newTruckProfileId);
			$this->setTruckBio($newTruckBio);
			$this->setTruckIsOpen($newTruckIsOpen);
			$this->setTruckLatitude($newTruckLatitude);
			$this->setTruckLongitude($newTruckLongitude);
			$this->setTruckName($newTruckName);
			$this->setTruckPhone($newTruckPhone);
			$this->setTruckUrl($newTruckUrl);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	// ACCESSORS AND MUTATORS

	/**
	 * accessor method for truckId
	 *
	 * @return Uuid value of truckId
	 **/
	public function getTruckId(): Uuid {
		return ($this->truckId);
	}

	/**
	 * mutator method for truckId
	 *
	 * @param Uuid|string $newTruckId new value of truck id
	 * @throws \RangeException if $newTruckId is not positive
	 * @throws \TypeError if $newTruckId is not a uuid or string
	 **/
	public function setTruckId($newTruckId): void {
		try {
			$uuid = self::validateUuid($newTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile id
		$this->truckId = $uuid;
	}

	/**
	 * accessor method for truckProfileId
	 *
	 * @return Uuid value of truckProfileId
	 **/
	public function getTruckProfileId(): Uuid {
		return ($this->truckProfileId);
	}

	/**
	 * mutator method for truckProfileId
	 *
	 * @param Uuid|string $newTruckProfileId new value of profile id
	 * @throws \RangeException if $newTruckProfileId is not positive
	 * @throws \TypeError if $newTruckProfileId is not a uuid or string
	 **/
	public function setTruckProfileId($newTruckProfileId): void {
		try {
			$uuid = self::validateUuid($newTruckProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the profile id
		$this->truckProfileId = $uuid;
	}

	/**
	 * accessor method for truckBio
	 *
	 * @return string value of truckBio
	 **/
	public function getTruckBio(): string {
		return ($this->truckBio);
	}

	/**
	 * mutator method for truckBio
	 *
	 * @param string $newTruckBio new value of truckBio
	 * @throws \TypeError if $newTruckBio is not a string
	 * @throws \InvalidArgumentException if input is empty
	 * @throws \RangeException if $newTruckBio > 1024 chars
	 **/
	public function setTruckBio(string $newTruckBio): void {
		// verify the token is secure
		$newTruckBio = trim($newTruckBio);
		$newTruckBio = filter_var($newTruckBio, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTruckBio) === true) {
			throw(new \InvalidArgumentException("Truck bio value is empty or insecure"));
		}

		if(strlen($newTruckBio) > 1024) {
			throw(new \RangeException("Truck bio input too long"));
		}
		// store new truckBio
		$this->truckBio = $newTruckBio;

	}

	/**
	 * accessor method for truckIsOpen
	 *
	 * @return int value of truckIsOpen
	 **/
	public function getTruckIsOpen(): int {
		return ($this->truckIsOpen);
	}

	/**
	 * accessor method for truckLatitude
	 *
	 * @return float value of truckLatitude
	 **/
	public function getTruckLatitude(): float {
		return ($this->truckLatitude);
	}

	/**
	 * accessor method for truckLongitude
	 *
	 * @return float value of truckLongitude
	 **/
	public function getTruckLongitude(): float {
		return ($this->truckLongitude);
	}

	/**
	 * accessor method for truckName
	 *
	 * @return string value of truckName
	 **/
	public function getTruckName(): string {
		return ($this->truckName);
	}

	/**
	 * mutator method for truckName
	 *
	 * @param string $newTruckName new value of truckName
	 * @throws \TypeError if $newTruckName is not a string
	 * @throws \InvalidArgumentException if input is empty
	 * @throws \RangeException if $newTruckName > 64 chars
	 **/
	public function setTruckName(string $newTruckName): void {
		// verify the token is secure
		$newTruckName = trim($newTruckName);
		$newTruckName = filter_var($newTruckName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTruckName) === true) {
			throw(new \InvalidArgumentException("Truck name value is empty or insecure"));
		}

		if(strlen($newTruckName) > 64) {
			throw(new \RangeException("Truck name too long"));
		}
		// store new truckName
		$this->truckName = $newTruckName;

	}

	/**
	 * accessor method for truckPhone
	 *
	 * @return int value of truckPhone
	 **/
	public function getTruckPhone(): int {
		return ($this->truckPhone);
	}

	/**
	 * mutator method for truckPhone
	 *
	 * @param string $newTruckPhone new value of truckPhone
	 * @throws \TypeError if $newTruckPhone is not a string
	 * @throws \InvalidArgumentException if input is empty
	 * @throws \RangeException if $newTruckPhone > 24 chars
	 **/
	public function setTruckPhone(string $newTruckPhone): void {
		// verify the token is secure
		$newTruckPhone = trim($newTruckPhone);
		$newTruckPhone = filter_var($newTruckPhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTruckPhone) === true) {
			throw(new \InvalidArgumentException("Truck phone number value is empty or insecure"));
		}

		if(strlen($newTruckPhone) > 24) {
			throw(new \RangeException("Truck phone number input too long"));
		}
		// store new truckBio
		$this->truckPhone = $newTruckPhone;

	}

	/**
	 * accessor method for truckUrl
	 *
	 * @return string value of truckUrl
	 **/
	public function getTruckUrl(): string {
		return ($this->truckUrl);
	}

	/**
	 * mutator method for truckUrl
	 *
	 * @param string $newTruckUrl new value of truckUrl
	 * @throws \TypeError if $newTruckUrl is not a string
	 * @throws \InvalidArgumentException if input is empty
	 * @throws \RangeException if $newTruckUrl > 128 chars
	 **/
	public function setTruckPhone(string $newTruckPhone): void {
		// verify the token is secure
		$newTruckPhone = trim($newTruckPhone);
		$newTruckPhone = filter_var($newTruckPhone, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTruckPhone) === true) {
			throw(new \InvalidArgumentException("Truck phone number value is empty or insecure"));
		}

		if(strlen($newTruckPhone) > 24) {
			throw(new \RangeException("Truck phone number input too long"));
		}
		// store new truckBio
		$this->truckPhone = $newTruckPhone;

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

}