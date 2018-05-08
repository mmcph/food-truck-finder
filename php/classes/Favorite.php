<?php

namespace Edu\Cnm\food-truck-finder;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;


class favorite implements \JsonSerializable {

	/**
	 * foreign key
	 * @var
	 */
	private $favoriteTruckId;

	/**
	 *foreign key
	 * @var
	 */
	private $favoriteProfileId;




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
		$this->favoriteTruckId = $favoriteTruckId;
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
	 * @param Uuid value of $favoriteProfileId
	 */
	public function setFavoriteProfileId($newFavoriteProfileId): void {
		$this->favoriteProfileId = $favoriteProfileId;
	}



	}

