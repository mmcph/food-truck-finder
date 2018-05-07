<?php
/**
 * Created by PhpStorm.
 * User: marlon
 * Date: 5/7/18
 * Time: 3:34 PM
 */
namespace Edu\Cnm\DataDesign;

require_once("autoload.php");

require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");


use Ramsey\Uuid\Uuid;

/**
 *
 *
 * @author Manuel Escobar III <mescobar14@cnm.edu>
 *
 **/
class TruckCategory implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * id for this truckCategoryCategoryId; this is the primary key
	 * @var Uuid $truckCategoryCategoryId
	 **/
	protected $truckCategoryCategoryId;

	/**
	 * id for truckCategoryTruckId; this is the primary key
	 * @var Uuid $truckCategoryTruckId
	 **/
	protected $truckCategoryTruckId;

// Constructor

	/**
	 * constructor for this TruckCategory
	 *
	 * @param string|Uuid $truckCategoryCategoryId; id of this truck CategoryId
	 * @param string|Uuid $truckCategoryTruckId; id of this truck Category Truck Id
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($truckCategoryCategoryId, $truckCategoryTruckId) {
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
	 * accessor method for getting personaId
	 * @return Uuid value of personaId
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
	public function setTruckCategoryCategoryId($newTruckCategoryCategoryId): void {
		try {
			$uuid = self::validateUuid($newTruckCategoryCategoryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->truckCategoryCategoryId = $uuid;
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
	 * stays at bottom of class page
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {

		$fields = get_object_vars($this);
		$fields["personaId"] = $this->personaId->toString();
		return ($fields);
	}
}
