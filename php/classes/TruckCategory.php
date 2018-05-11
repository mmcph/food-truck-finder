<?php

namespace Edu\Cnm\FoodTruck;

require_once("autoload.php");

require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");


use Ramsey\Uuid\Uuid;

/**
 * Class TruckCategory- Represents the Category of Trucks
 *--side note--->  class needs more detail
 * @author Manuel Escobar III <mescobar14@cnm.edu>
 *
 **/
class TruckCategory implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * id for this truckCategoryCategoryId; this is the primary key
	 * @var int $truckCategoryCategoryId
	 **/
	private $truckCategoryCategoryId;

	/**
	 * id for truckCategoryTruckId; this is the primary key
	 * @var Uuid $truckCategoryTruckId
	 **/
	private $truckCategoryTruckId;

// Constructor

	/**
	 * constructor for this TruckCategory
	 *
	 * @param int | $truckCategoryCategoryId; id of this truck CategoryId
	 * @param string|Uuid $truckCategoryTruckId; id of this truck Category Truck Id
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(int $truckCategoryCategoryId, $truckCategoryTruckId) {
		try {
			$this->setTruckCategoryCategoryId($truckCategoryCategoryId);
			$this->setTruckCategoryTruckId($truckCategoryTruckId);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}



	/**
	 * accessor method for getting truckCategoryId
	 * @return Uuid value of truckCategoryId
	 *
	 */
	public function getTruckCategoryCategoryId(): Uuid {
		return ($this->truckCategoryCategoryId);
	}

	/**
	 * mutator method for $truckCategoryCategoryId
	 *
	 * @param mixed $newTruckCategoryCategoryId
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not a uuid or string
	 *
	 */
	public function setTruckCategoryCategoryId(int $newTruckCategoryCategoryId): void {
		if ($newTruckCategoryCategoryId < 0 || $newTruckCategoryCategoryId >255){
			throw new \RangeException("truckCategoryCategoryId is out of range");
		}

		// convert and store the truckCategoryCategoryId
		$this->truckCategoryCategoryId = $newTruckCategoryCategoryId;
	}




	/**
	 * accessor method for getting personaId
	 * @return Uuid value of personaId
	 *
	 */
	public function getTruckCategoryTruckId(): Uuid {
		return ($this->truckCategoryCategoryId);
	}



	/**
	 * mutator method for $truckCategoryCategoryId
	 *
	 * @param mixed $newTruckCategoryTruckId
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not a uuid or string
	 *
	 */
	public function setTruckCategoryTruckId($newTruckCategoryTruckId): void {
		try {
			$uuid = self::validateUuid($newTruckCategoryTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->$newTruckCategoryTruckId = $uuid;
	}



	/**
	 * -- inserts this truckCategory into mySQL
	 *
	 * -- @param \PDO $pdo PDO connection object
	 * -- @throws \PDOException when mySQL related errors occur
	 * -- @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {

		$query = "INSERT INTO truckCategory(truckCategoryCategoryId, truckCategoryTruckId) VALUES(:truckCategoryCategoryId, :truckCategoryTruckId)";
		$statement = $pdo->prepare($query);
		$parameters = ["truckCategoryCategoryId" => $this->truckCategoryCategoryId->getBytes(),"truckCategoryTruckId" => $this->truckCategoryTruckId->getBytes()];
		$statement->execute($parameters);
	}


	public function delete(\PDO $pdo): void {


		// create query template
		$query = "DELETE FROM TruckCategory WHERE TruckCategoryId = :TruckCategoryId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["TruckCategoryId" => $this->TruckCategoryId->getBytes()];
		$statement->execute($parameters);
	}


	/**
	 * gets the TruckCategory by TruckCategoryCategoryId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid| string $truckCategoryCategoryId TruckCategory id to search for
	 * @return TruckCategory|null Truck found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/




	public static function getTruckCategoryByTruckCategoryCategoryIdAndTruckCategoryTruckId(\PDO $pdo, $truckCategoryCategoryId, $truckCategoryTruckId): ?TruckCategory {

		// create query template
		$query = "SELECT truckCategoryCategoryId, truckCategoryTruckId FROM truckCategory WHERE truckCategoryCategoryId = :truckCategoryCategoryId AND truckCategoryTruckId = :truckCategoryTruckId";
		$statement = $pdo->prepare($query);

		// bind the truckCategory id to the place holder in the template
		$parameters = ["truckCategory" => $truckCategoryCategoryId,"truckCategoryTruckId" => $truckCategoryTruckId];
		$statement->execute($parameters);

		// grab the truckCategory from mySQL
		try {
			$truckCategory = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$truckCategory = new truckCategory($row["truckCategoryCategoryId"], $row["truckCategoryTruckId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($truckCategory);
	}


	//TODO: getTruckCategoryByTruckCategoryCategoryId
	public static function getTruckCategoryByTruckCategoryCategoryId(\PDO $pdo, $truckCategoryCategoryId ):?TruckCategory {

		// create query template
		$query = "SELECT truckCategoryCategoryId, FROM truckCategory WHERE truckCategoryCategoryId = :truckCategoryCategoryId" ;
		$statement = $pdo->prepare($query);


		// bind the truckCategory id to the place holder in the template
		$parameters = ["truckCategory" => $truckCategoryCategoryId];
		$statement->execute($parameters);

		// grab the truckCategory from mySQL
		try {
			$truckCategory = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$truckCategory = new TruckCategory($row["truckCategoryCategoryId"], $row["truckCategoryCategoryId"],
				$row["truckCategoryTruckId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($truckCategory);
	}
// Not finished








	/**
	 * gets the TruckCategory by TruckCategoryTruckId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid| string $truckCategoryTruckId TruckCategory id to search for
	 * @return TruckCategory|null Truck found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getTruckCategoryByTruckCategoryTruckId(\PDO $pdo, $truckCategoryTruckId): \SPLFixedArray  {
		// sanitize the truckCategoryId before searching
		try {
			$truckCategoryTruckId = self::validateUuid($truckCategoryTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT truckCategoryCategoryId, truckCategoryTruckId FROM truckCategory WHERE truckCategoryTruckId = :truckCategoryTruckId";
		$statement = $pdo->prepare($query);

		// bind the truckCategory id to the place holder in the template
		$parameters = ["truckCategory" => $truckCategoryTruckId->getBytes()];
		$statement->execute($parameters);

		//build an array on truckCategory
		$truckCategories = new \SPLFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		// grab the truckCategory from mySQL
		try {
			$truckCategory = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$truckCategory = new TruckCategory($row["truckCategoryCategoryId"], $row["truckCategoryTruckId"],
				$row["truckCategoryCategoryId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($truckCategory);
	}



	/**
	 * stays at bottom of class page
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		$fields["truckCategoryCategoryId"] = $this->truckCategoryCategoryId->toString();
		$fields["truckCategoryTruckId"] = $this->truckCategoryTruckId->toString();
		return ($fields);
	}
}
