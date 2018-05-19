<?php
namespace Edu\Cnm\FoodTruck;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 * Class: favorite
 *
 * this class will allow registered "CUSTOMER profile" to save a truck class to a list that is labeled as their "favorites"
 * this will make it easy for customers to save the trucks that they would like to remember, thus return to.
 *
 * @author G. Cordova
 * @package Edu\Cnm\FoodTruck
 */
class favorite implements \JsonSerializable {

	use ValidateUuid;

	/**
	 * foreign key
	 * @var Uuid|string $favoriteTruckId
	 */
	private $favoriteTruckId;

	/**
	 * foreign key
	 * @var Uuid|string $favoriteProfileId
	 */
	private $favoriteProfileId;


	/**
	 * favorite constructor.
	 * @param $newFavoriteProfileId
	 * @param $newFavoriteTruckId
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws \Exception if some other exception is thrown
     * @throws \TypeError if data types violate type hints
	 */
	public function __construct($newFavoriteProfileId, $newFavoriteTruckId) {
		try {
            $this->setFavoriteTruckId($newFavoriteTruckId);
            $this->setFavoriteProfileId($newFavoriteProfileId);

        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 *
	 * accessor method
	 * @return Uuid value of $favoriteTruckId
	 */
	public function getFavoriteTruckId(): string {
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
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->favoriteTruckId = $uuid;
	}

	/**
	 * accessor method
	 *
	 * @return Uuid
	 */
	public function getFavoriteProfileId(): string {
		return $this->favoriteProfileId;
	}

	/**
	 * mutator method
	 *
	 * @param Uuid | string value of $favoriteProfileId
	 * @throws \RangeException if $newFavoriteProfileId is not positive
	 * @throws \TypeError if $newFavoriteProfileId is not a string
	 */
	public function setFavoriteProfileId($newFavoriteProfileId) : void {
		try {
			$uuid = self::validateUuid($newFavoriteProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
			$this->favoriteProfileId = $uuid;
	}
	/**
	 * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
	 */


	public function insert(\PDO $pdo): void {
	    // create a query template
		$query = "INSERT INTO favorite (favoriteTruckId, favoriteProfileId) VALUES (:favoriteTruckId, :favoriteProfileId)";
		$statement = $pdo->prepare($query);
        //bind the member variables to the place holders in the template
		$parameters = ["favoriteTruckId" => $this->favoriteTruckId->getBytes(), "favoriteProfileId" => $this->favoriteProfileId->getBytes ()];
		$statement->execute($parameters);
	}

	public function delete(\PDO $pdo): void {
		$query = "DELETE FROM favorite WHERE favoriteTruckId = :favoriteTruckId and favoriteProfileId = :favoriteProfileId";
		$statement = $pdo->prepare($query);
		$parameters = ["favoriteTruckId" => $this->favoriteTruckId->getBytes(), "favoriteProfileId" => $this->favoriteProfileId->getBytes()];
		$statement->execute($parameters);
	}
    /**
     *
     * gets the favorite by truck id
     * @param \PDO $pdo PDO connection object
     * @param string $favoriteTruckId id to search for
     * @return \SplFixedArray array of Likes found or null if not found
     * @throws \PDOException when mySQL related errors occur
     **/

	public static function getFavoriteByFavoriteTruckId (\PDO $pdo, string $favoriteTruckId) : \SplFixedArray {
		try {
			$favoriteTruckId = self::validateUuid($favoriteTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

        // create query template
		$query = "SELECT favoriteTruckId, favoriteProfileId FROM favorite WHERE favoriteTruckId = :favoriteTruckId";
		$statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
		$parameters = ["favoriteTruckId" => $favoriteTruckId->getBytes()];
		$statement->execute($parameters);

        // build the array of likes
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new Favorite($row["favoriteTruckId"], $row["favoriteProfileId"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($favorites);
	}

    /**
     * @param \PDO $pdo
     * @param string $favoriteProfileId to search by
     * @return \SplFixedArray of favorites found
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     */


	public static function getFavoriteByFavoriteProfileId(\PDO $pdo, string $favoriteProfileId) : \SplFixedArray {
		try {
			$favoriteProfileId = self::validateUuid($favoriteProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT favoriteTruckId, favoriteProfileId FROM favorite WHERE favoriteProfileId = :favoriteProfileId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["favoriteProfileId" => $favoriteProfileId->getBytes()];
		$statement->execute($parameters);

		//build an array of favorites
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new Favorite($row["favoriteTruckId"], $row["favoriteProfileId"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($favorites);
	}

    /**
     * @param \PDO $pdo
     * @param string $favoriteTruckId
     * @param string $favoriteProfileId
     * @return favorite|null
     */
	public static function getFavoriteByFavoriteTruckIdAndFavoriteProfileId(\PDO $pdo, string $favoriteTruckId, string $favoriteProfileId) {
			try {
				$favoriteTruckId = self::validateUuid($favoriteTruckId);
			} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}


			try {
				$favoriteProfileId = self::validateUuid($favoriteProfileId);
			} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}

            // create query template
			$query = "SELECT favoriteTruckId, favoriteProfileId FROM `favorite` WHERE favoriteTruckId = :favoriteTruckId AND favoriteProfileId = :favoriteProfileId";
			$statement = $pdo->prepare($query);

			// bind the truck id and the profile id to the place holder in the template
			$parameters = ["favoriteTruckId" => $favoriteTruckId->getBytes(), "favoriteProfileId" => $favoriteProfileId->getBytes()];
			$statement->execute($parameters);

			// grab the favorite from mySQL
			try {
				$favorite = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$favorite = new Favorite($row["favoriteTruckId"], $row["favoriteProfileId"]) ;
				}
			} catch(\Exception $exception) {
			    // if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($favorite);
		}

	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		$fields["favoriteTruckId"] = $this->favoriteTruckId->toString();
		$fields["favoriteProfileId"];
		return ($fields);
	}
}
