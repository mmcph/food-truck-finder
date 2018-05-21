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
	 * @param Uuid|string $newFavoriteProfileId
	 * @param Uuid|string $newFavoriteTruckId
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws \Exception if some other exception is thrown
     * @throws \TypeError if data types violate type hints
	 */
	public function __construct($newFavoriteProfileId, $newFavoriteTruckId) {
		try {
            $this->setFavoriteProfileId($newFavoriteProfileId);
            $this->setFavoriteTruckId($newFavoriteTruckId);

        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 *
	 * accessor method
	 * @return Uuid|string value of $favoriteTruckId
	 */
	public function getFavoriteTruckId(): Uuid {
		return ($this->favoriteTruckId);
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
	public function getFavoriteProfileId(): Uuid {
		return ($this->favoriteProfileId);
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
        // convert and store the profile id
			$this->favoriteProfileId = $uuid;
	}
	/**
	 * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
	 */


	public function insert(\PDO $pdo): void {
	    // create a query template
		$query = "INSERT INTO favorite (favoriteProfileId,favoriteTruckId) VALUES (:favoriteProfileId, :favoriteTruckId)";
		$statement = $pdo->prepare($query);
        //bind the member variables to the place holders in the template
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId->getBytes (),"favoriteTruckId" => $this->favoriteTruckId->getBytes()];
		$statement->execute($parameters);
	}

	public function delete(\PDO $pdo): void {
		$query = "DELETE FROM favorite WHERE favoriteProfileId = :favoriteProfileId  and favoriteTruckId = :favoriteTruckId";
		$statement = $pdo->prepare($query);
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId->getBytes(), "favoriteTruckId" => $this->favoriteTruckId->getBytes()];
		$statement->execute($parameters);
	}
    /**
     *
     * gets the favorite by truck id
     * @param \PDO $pdo PDO connection object
     * @param Uuid|string $favoriteTruckId id to search for
     * @return \SplFixedArray array of Likes found or null if not found
     * @throws \PDOException when mySQL related errors occur
     **/

	public static function getFavoriteByFavoriteTruckId (\PDO $pdo, $favoriteTruckId) : \SplFixedArray {
		try {
			$favoriteTruckId = self::validateUuid($favoriteTruckId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

        // create query template
		$query = "SELECT favoriteProfileId, favoriteTruckId  FROM favorite WHERE favoriteTruckId = :favoriteTruckId";
		$statement = $pdo->prepare($query);

        // bind the member variables to the place holders in the template
		$parameters = ["favoriteTruckId" => $favoriteTruckId->getBytes()];
		$statement->execute($parameters);

        // build the array of likes
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteTruckId"]);
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
     * @param Uuid|string $favoriteProfileId to search by
     * @return \SplFixedArray of favorites found
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     */


	public static function getFavoriteByFavoriteProfileId(\PDO $pdo, $favoriteProfileId) : \SplFixedArray {
		try {
			$favoriteProfileId = self::validateUuid($favoriteProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT favoriteProfileId, favoriteTruckId FROM favorite WHERE favoriteProfileId = :favoriteProfileId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["favoriteProfileId" => $favoriteProfileId->getBytes()];
		$statement->execute($parameters);

		//build an array of favorites
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteTruckId"]);
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
     * @param string|Uuid  $favoriteTruckId
     * @param string|Uuid $favoriteProfileId
     * @return favorite|null
     */
	public static function getFavoriteByFavoriteProfileIdAndFavoriteTruckId(\PDO $pdo,  $favoriteProfileId,  $favoriteTruckId) {
        try {
            $favoriteProfileId = self::validateUuid($favoriteProfileId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }

	    try {
				$favoriteTruckId = self::validateUuid($favoriteTruckId);
			} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}

            // create query template
			$query = "SELECT favoriteProfileId, favoriteTruckId FROM `favorite` WHERE favoriteProfileId = :favoriteProfileId AND favoriteTruckId = :favoriteTruckId";
			$statement = $pdo->prepare($query);

			// bind the truck id and the profile id to the place holder in the template
			$parameters = ["favoriteProfileId" => $favoriteProfileId->getBytes(), "favoriteTruckId" => $favoriteTruckId->getBytes()];
			$statement->execute($parameters);

			// grab the favorite from mySQL
			try {
				$favorite = null;
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteTruckId"]) ;
				}
			} catch(\Exception $exception) {
			    // if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($favorite);
		}

	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		$fields["favoriteProfileId"] = $this->favoriteTruckId->toString();
		$fields["favoriteTruckId"];
		return ($fields);
	}
}
