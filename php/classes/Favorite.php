<?php
namespace Edu\Cnm\food-truck-finder;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;


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