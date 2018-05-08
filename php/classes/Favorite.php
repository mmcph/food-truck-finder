<?php

namespace Edu\Cnm\food-truck-finder;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;


class favorite {


	private $favoriteTruckId;

	private $favoriteProfileId;




	/**
	 * accessor method
	 * @return mixed
	 */
	public function getFavoriteTruckId() {
		return $this->favoriteTruckId;
	}

	/**
	 * @param mixed $favoriteTruckId
	 */
	public function setFavoriteTruckId($favoriteTruckId): void {
		$this->favoriteTruckId = $favoriteTruckId;
	}

	/**
	 * @return mixed
	 */
	public function getFavoriteProfileId() {
		return $this->favoriteProfileId;
	}

	/**
	 * @param mixed $favoriteProfileId
	 */
	public function setFavoriteProfileId($favoriteProfileId): void {
		$this->favoriteProfileId = $favoriteProfileId;
	}



	}

