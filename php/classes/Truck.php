<?php

namespace Edu\Cnm\FoodTruck;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Class truck - represents each individual food truck. Weak entity; one profile may have many food trucks.
 * @package Edu\Cnm\FoodTruck
 *
 * @author: Marlon McPherson (marlon.c.mcpherson@gmail.com)
 */
class Truck implements \JsonSerializable {

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
	 * latitudinal coordinate for truck location
	 * @var float $truckLatitude
	 **/
	protected $truckLatitude;
	/**
	 * longitudinal coordinate for truck location
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
	// todo check with bridge regarding UUID type declarations and consequences of removing them
	public function __construct($newTruckId, $newTruckProfileId, string $newTruckBio, int $newTruckIsOpen, float $newTruckLatitude, float $newTruckLongitude, string $newTruckName, int $newTruckPhone, string $newTruckUrl) {
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
	 * mutator method for truckIsOpen
	 *
	 * @param int $newTruckIsOpen new value of truckIsOpen
	 * @throws \TypeError if $newTruckIsOpen is not an integer
	 * @throws \RangeException if $newTruckIsOpen too small OR too large OR empty string
	 **/
	public function setTruckIsOpen(int $newTruckIsOpen): void {

		if($newTruckIsOpen < -1 || $newTruckIsOpen > 1) {
			throw(new \RangeException("TruckIsOpen is not -1 or 1"));
		}
		// store new truckIsOpen
		$this->truckIsOpen = $newTruckIsOpen;

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
	 * mutator method for truckLatitude
	 *
	 * @param float $newTruckLatitude new value of truckLatitude
	 * @throws \TypeError if $newTruckLatitude is not a float
	 * @throws \RangeException if $newTruckLatitude too small OR too large OR empty string
	 **/
	public function setTruckLatitude(float $newTruckLatitude): void {

		if($newTruckLatitude < -90 || $newTruckLatitude > 90 || empty($newTruckLatitude) === true) {
			throw(new \RangeException("Invalid latitude value: must be in range [-90,90]"));
		}
		// store new truckLatitude
		$this->truckLatitude = $newTruckLatitude;

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
	 * mutator method for truckLongitude
	 *
	 * @param float $newTruckLongitude new value of truckLongitude
	 * @throws \TypeError if $newTruckLongitude is not a float
	 * @throws \RangeException if $newTruckLongitude too small OR too large OR empty string
	 **/
	public function setTruckLongitude(float $newTruckLongitude): void {

		if($newTruckLongitude < -180 || $newTruckLongitude > 180) {
			throw(new \RangeException("Invalid longitude value: must be in range [-180,180]"));
		}
		// store new truckLongitude
		$this->truckLongitude = $newTruckLongitude;

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
		// store new truckPhone
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
	public function setTruckUrl(string $newTruckUrl): void {
		// verify the token is secure
		$newTruckUrl = trim($newTruckUrl);
		$newTruckUrl = filter_var($newTruckUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newTruckUrl) === true) {
			throw(new \InvalidArgumentException("Truck url value is empty or insecure"));
		}

		if(strlen($newTruckUrl) > 24) {
			throw(new \RangeException("Truck url input too long"));
		}
		// store new truckUrl
		$this->truckUrl = $newTruckUrl;

	}

	// PDO Methods

	/** inserts new truck into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function insert(\PDO $pdo): void {

		// create query template
		$query = "INSERT INTO truck(truckId, truckProfileId, truckBio, truckIsOpen, truckLatitude, truckLongitude, truckName, truckPhone, truckUrl) VALUES(:truckId, :truckProfileId, :truckBio, :truckIsOpen, :truckLatitude, :truckLongitude, :truckName, :truckPhone, :truckUrl)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholders in the template
		$parameters = ["truckId" => $this->truckId->getBytes(), "truckProfileId" => $this->truckProfileId->getBytes(), "truckBio" => $this->truckBio, "truckIsOpen" => $this->truckIsOpen, "truckLatitude" => $this->truckLatitude, "truckLongitude" => $this->truckLongitude, "truckName" => $this->truckName, "truckPhone" => $this->truckPhone, "truckUrl" => $this->truckUrl];
		$statement->execute($parameters);
	}

	/** deletes this truck from mysql
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function delete(\PDO $pdo): void {

		// create query template
		$query = "DELETE FROM truck WHERE truckId = :truckId";
		$statement = $pdo->prepare($query);

		// bind member vars to placeholder in template
		$parameters = ["truckId" => $this->truckId->getBytes()];
		$statement->execute($parameters);
	}

	/** updates this truck in mysql
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

	public function update(\PDO $pdo): void {

		// create query template
		$query = "UPDATE truck SET truckProfileId = :truckProfileId, truckBio = :truckBio, truckIsOpen = :truckIsOpen, truckLatitude = :truckLatitude, truckLongitude = :truckLongitude, truckName = :truckName, truckPhone = :truckPhone, truckUrl = :truckUrl WHERE truckId = :truckId";
		$statement = $pdo->prepare($query);

		$parameters = ["truckId" => $this->truckId->getBytes(), "truckProfileId" => $this->truckProfileId->getBytes(), "truckBio" => $this->truckBio, "truckIsOpen" => $this->truckIsOpen, "truckLatitude" => $this->truckLatitude, "truckLongitude" => $this->truckLongitude, "truckName" => $this->truckName, "truckPhone" => $this->truckPhone, "truckUrl" => $this->truckUrl];
		$statement->execute($parameters);
	}

	/**
	 * gets the Truck by truckId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $truckId truck id to search for
	 * @return Truck|null Truck found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getTruckByTruckId(\PDO $pdo, $truckId): ?Truck {
		// sanitize the truckId before searching
		try {
			$truckId = self::validateUuid($truckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT truckId, truckProfileId, truckBio, truckIsOpen, truckLatitude, truckLongitude, truckName, truckPhone, truckUrl FROM truck WHERE truckId = :truckId";
		$statement = $pdo->prepare($query);

		// bind the truck id to the place holder in the template
		$parameters = ["truckId" => $truckId->getBytes()];
		$statement->execute($parameters);

		// grab the truck from mySQL
		try {
			$truck = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$truck = new Truck($row["truckId"], $row["truckProfileId"], $row["truckBio"], $row["truckIsOpen"], $row["truckLatitude"], $row["truckLongitude"], $row["truckName"], $row["truckPhone"], $row["truckUrl"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($truck);
	}

	/**
	 * gets the Truck by truckProfileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $truckProfileId truck profileId to search for
	 * @return Truck|null Truck found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getTruckByTruckProfileId(\PDO $pdo, string $truckProfileId): \SPLFixedArray {
		// sanitize the truckProfileId before searching
		try {
			$truckProfileId = self::validateUuid($truckProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT truckId, truckProfileId, truckBio, truckIsOpen, truckLatitude, truckLongitude, truckName, truckPhone, truckUrl FROM truck WHERE truckProfileId = :truckProfileId";
		$statement = $pdo->prepare($query);

		// bind the truckProfileId to the place holder in the template
		$parameters = ["truckProfileId" => $truckProfileId->getBytes()];
		$statement->execute($parameters);

		//build array of trucks
		$trucks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		// grab the truck from mySQL
		while(($row = $statement->fetch()) !== false) {
			try {
					$truck = new Truck($row["truckId"], $row["truckProfileId"], $row["truckBio"], $row["truckIsOpen"], $row["truckLatitude"], $row["truckLongitude"], $row["truckName"], $row["truckPhone"], $row["truckUrl"]);
					$trucks[$trucks->key()] = $truck;
					$trucks->next();

			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($trucks);
	}

	/**
	 * gets the Truck by truckIsOpen
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $truckIsOpen truck open/closed status to search for
	 * @return Truck|null Truck found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getTruckByTruckIsOpen(\PDO $pdo, int $truckIsOpen): \SplFixedArray {
		// create query template
		$query = "SELECT truckId, truckProfileId, truckBio, truckIsOpen, truckLatitude, truckLongitude, truckName, truckPhone, truckUrl FROM truck WHERE truckIsOpen = :truckIsOpen";
		$statement = $pdo->prepare($query);

		// bind the truckIsOpen to the place holder in the template
		$parameters = ["truckIsOpen" => $truckIsOpen];
		$statement->execute($parameters);

		//build array of trucks
		$trucks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		// grab the truck from mySQL
		while(($row = $statement->fetch()) !== false) {
			try {
				$truck = new Truck($row["truckId"], $row["truckProfileId"], $row["truckBio"], $row["truckIsOpen"], $row["truckLatitude"], $row["truckLongitude"], $row["truckName"], $row["truckPhone"], $row["truckUrl"]);
				$trucks[$trucks->key()] = $truck;
				$trucks->next();

			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($trucks);
	}

	/**
	 * gets the Truck by truckName
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $truckName truck name to search for
	 * @return Truck|null Truck found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getTruckByTruckName(\PDO $pdo, $truckName): ?Truck {
		// verify the token is secure
		$truckName = trim($truckName);
		$truckName = filter_var($truckName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($truckName) === true) {
			throw(new \InvalidArgumentException("Enter a truck name to search for."));
		}

		// create query template
		$query = "SELECT truckId, truckProfileId, truckBio, truckIsOpen, truckLatitude, truckLongitude, truckName, truckPhone, truckUrl FROM truck WHERE truckName LIKE :truckName";
		$statement = $pdo->prepare($query);

		// bind the truckIsOpen to the place holder in the template
		$parameters = ["truckName" => $truckName];
		$statement->execute($parameters);

		// grab the truck from mySQL
		while(($row = $statement->fetch()) !== false) {
			try {
				$truck = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$truck = new Truck($row["truckId"], $row["truckProfileId"], $row["truckBio"], $row["truckIsOpen"], $row["truckLatitude"], $row["truckLongitude"], $row["truckName"], $row["truckPhone"], $row["truckUrl"]);
				}
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($truck);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields["truckId"] = $this->truckId->toString();
		$fields["truckProfileId"] = $this->truckProfileId->toString();

		return ($fields);
	}

}