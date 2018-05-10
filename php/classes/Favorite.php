<?php
namespace Edu\Cnm\food-truck-finder;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;


/**
 * Trait: ValidateUuid
 * This trait will validate proper UUIDs for the following formats:
 * -human readable string (36 bytes)
 * -binary string (16 bytes)
 * -Ramsey\Uuid\Uuid object
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @package Edu\Cnm\food-truck-finder
 */
trait ValidateUuid {
	/**
	 * validates a uuid irrespective of format
	 *
	 * @param string|Uuid $newUuid uuid to validate
	 * @return Uuid object with validated uuid
	 * @throws \InvalidArgumentException if $newUuid is not a valid uuid
	 * @throws \RangeException if $newUuid is not a valid uuid v4
	 **/
	private static function validateUuid($newUuid) : Uuid {
		// verify a string uuid
		if(gettype($newUuid) === "string") {
			// 16 characters is binary data from mySQL - convert to string and fall to next if block
			if(strlen($newUuid) === 16) {
				$newUuid = bin2hex($newUuid);
				$newUuid = substr($newUuid, 0, 8) . "-" . substr($newUuid, 8, 4) . "-" . substr($newUuid,12, 4) . "-" . substr($newUuid, 16, 4) . "-" . substr($newUuid, 20, 12);
			}
			// 36 characters is a human readable uuid
			if(strlen($newUuid) === 36) {
				if(Uuid::isValid($newUuid) === false) {
					throw(new \InvalidArgumentException("invalid uuid"));
				}
				$uuid = Uuid::fromString($newUuid);
			} else {
				throw(new \InvalidArgumentException("invalid uuid"));
			}
		} else if(gettype($newUuid) === "object" && get_class($newUuid) === "Ramsey\\Uuid\\Uuid") {
			// if the misquote id is already a valid UUID, press on
			$uuid = $newUuid;
		} else {
			// throw out any other trash
			throw(new \InvalidArgumentException("invalid uuid"));
		}
		// verify the uuid is uuid v4
		if($uuid->getVersion() !== 4) {
			throw(new \RangeException("uuid is incorrect version"));
		}
		return($uuid);
	}
}

/**
 * Class: favorite
 *
 * this class will allow registered "CUSTOMER profile" to save a truck class to a list that is labeled as their "favorites"
 * this will make it easy for customers to save the trucks that they would like to remember, thus return to.
 *
 * @author G. Cordova
 * @package Edu\Cnm\food
 */
class favorite implements \JsonSerializable {

	/**
	 * foreign key
	 * @var Uuid $favoriteTruckId
	 */
	private $favoriteTruckId;

	/**
	 *foreign key
	 * @var Uuid $favoriteProfileId
	 */
	private $favoriteProfileId;


	/**
	 * favorite constructor.
	 * @param $favoriteTruckId
	 * @param $favoriteProfileId
	 */
	public function __construct($favoriteTruckId, $favoriteProfileId) {
		try {
			$this->favoriteTruckId($newFavoriteTruckId);
			$this->favoriteProfileId($newFavoriteProfileId);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 *
	 * accessor method
	 * @return Uuid value of $favoriteTruckId
	 */
	public function getFavoriteTruckId() : string {
		return $this->favoriteTruckId;
	}

	/**
	 * mutator method
	 *
	 * @param Uuid | string value of  $newFavoriteTruckId
	 * @throws \InvalidArgumentException if $newFavoriteTruck is not a string or insecure
	 * @throws \RangeException if $newFavoriteTruck is not positive
	 * @throws \TypeError if $newFavoriteTruck is not a string
	 */
	public function setFavoriteTruckId($newFavoriteTruckId): void {
		try {
			$uuid = self::validateUuid($newFavoriteTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
		}
		$this->favoriteTruckId = $newFavoriteTruckId;
	}

	/**
	 * accessor method
	 *
	 * @return Uuid
	 */
	public function getFavoriteProfileId() : string {
		return $this->favoriteProfileId;
	}

	/**
	 * mutator method
	 *
	 * @param Uuid | string value of $favoriteProfileId
	 * @throws \RangeException if $newFavoriteProfileId is not positive
	 * @throws \TypeError if $newFavoriteProfileId is not a string
	 */
	public function setTruckProfileId($newTruckProfileId): void {
		try {
			$uuid = self::validateUuid($newTruckProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
		}
		$this->favoriteTruckId = $uuid;
	}
	}

	/**
	 * PDO's
	 *
	 */


	public function insert(\PDO $pdo) : void {
		$query = "INSERT INTO favorite(favoriteTruckId, favoriteProfileId) VALUES (:favoriteTruckId, :favoriteProfileId)";
		$statement = $pdo->prepare($query);
		$parameters = ["favoriteTruckId" => $this->favoriteTruckId->getBytes(), "favoriteProfileId" => $this->favoriteProfileId->getBytes()];
		$statements->execute($parameters);
	}

	public function delete(\PDO $pdo) : void {
		$query = "DELETE FROM favorite WHERE favoriteTruckId = :favoriteTruckId and favoriteProfileId = :favoriteProfileId";
		$statement = $pdo->prepare($query);
		$parameters = ["favoriteTruckId" => $this->favoriteTruckId->getBytes(), "favoriteProfileId" => $this->favoriteProfileId->getBytes()];
		$statement->execute($parameters);
}

