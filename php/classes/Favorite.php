<?php

namespace Edu\Cnm\food-truck-finder;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;


class favorite implements \JsonSerializable {

	/**
	 * @var
	 */
	private $favoriteTruckId;

	/**
	 *
	 * @var
	 */
	private $favoriteProfileId;




	/**
	 *
	 * accessor method
	 * @return Uuid
	 */
	public function getFavoriteTruckId() : string {
		return $this->favoriteTruckId;
	}

	/**
	 * mutator method
	 * @param Uuid | string value of  $newFavoriteTruckId
	 */
	public function setFavoriteTruckId($favoriteTruckId): void {
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
	 * @param Uuid $favoriteProfileId
	 */
	public function setFavoriteProfileId($newFavoriteProfileId): void {
		$this->favoriteProfileId = $favoriteProfileId;
	}



	}

