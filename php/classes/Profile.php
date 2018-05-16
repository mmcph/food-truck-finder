<?php

namespace Edu\Cnm\FoodTruck;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;


/** activation token to gain access as a registered user/**
 * Class profile
 *
 * This class will serve as a platform in which users will utilize to gain access to "registered user" abilities, such as
 * being designated as a "vendor" or "customer"
 *
 * @package Edu\Cnm\food-truck-finder
 * @author G. Cordova
 */
class Profile implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * UNIQUE
	 * id for profile
	 * PRIMARY key
	 * @var Uuid $profileId
	 */
	private $profileId;
	/**
	 * UNIQUE
	 * activation token for this profile
	 * @var string $profileActivationToken
	 */
	private $profileActivationToken;

	/**
	 * UNIQUE
	 * email for profile
	 * @var string $profileEmail
	 */
	private $profileEmail;

	/**
	 * hash for profile (pw)
	 * @var mixed $profileHash
	 */
	private $profileHash;

	/**
	 * indication of whether or not the profile is one of a vendor
	 * @var bool $profileIsOwner
	 */
	private $profileIsOwner;

	/**
	 * first name of profile user
	 * @var string $profileFirstName
	 */
	private $profileFirstName;

	/**
	 * last name of profile user
	 * @var string $profileLastName
	 */
	private $profileLastName;

	/**
	 * UNIQUE
	 * user name of profile (handle)
	 * @var string $profileUserName
	 */
	private $profileUserName;


	/**
	 * @param $newProfileId
	 * @param string $newProfileActivationToken
	 * @param string $newProfileEmail
	 * @param string $newProfileHash
	 * @param int $newProfileIsOwner
	 * @param string $newProfileFirstName
	 * @param string $newProfileLastName
	 * @param string $newProfileUserName
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws  \Exception for any other errors
     * @throws \TypeError if data types violate type hints
	 */
	public function __construct($newProfileId, string $newProfileActivationToken, string $newProfileEmail, string $newProfileHash, int $newProfileIsOwner, string $newProfileFirstName, string $newProfileLastName, string $newProfileUserName) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfileIsOwner($newProfileIsOwner);
			$this->setProfileFirstName($newProfileFirstName);
			$this->setProfileLastName($newProfileLastName);
			$this->setProfileUserName($newProfileUserName);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method
	 *
	 * @return Uuid | string of profile id
	 */
	public function getProfileId(): Uuid {
		return $this->profileId;
	}

	/**
	 *mutator method
	 *
	 * @param Uuid | string value of  $newProfileId
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not a uuid or string
	 */
	public function setProfileId($newProfileId): void {
		try {
			$uuid = self::ValidateUuid($newProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->profileId = $uuid;
	}

	/*
	 * accessor method
	 * @return string value of $profileActivationToken
	 */
	function getProfileActivationToken(): string {
		return $this->profileActivationToken;
	}

	/*
	 * mutator method
	 *
	 * @params string of $newProfileActivationToken
	 * @throws \InvalidArgumentException if $newProfileActivationToken is not a string or insecure
	 * @throws \RangeException if $newProfileActivationToken
	 * @throws \TypeError if $newProfileActivationToken is not a uuid or string
	 */
	public function setProfileActivationToken($newProfileActivationToken) {
		$newProfileActivationToken = trim($newProfileActivationToken);
		$newProfileActivationToken = filter_var($newProfileActivationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileActivationToken) === true) {
			throw(new \InvalidArgumentException("Activation Token is empty or insecure"));
		}
		if(strlen($newProfileActivationToken) > 32) {
			throw(new \RangeException("Activation Token too large"));
		}
		$this->profileActivationToken = $newProfileActivationToken;
	}


	/**
	 * accessor method
	 * @return string value of profile email
	 */
	public function getProfileEmail(): string {
		return $this->profileEmail;
	}

	/**
	 * mutator method
	 *
	 * @param string value of $profileEmail
	 * @throws \InvalidArgumentException if $newProfileEmail is not a string or insecure
	 * @throws \RangeException if $newProfileEmail is > 255 characters
	 * @throws \TypeError if $newProfileEmail is not a string
	 */
	public function setProfileEmail(string $newProfileEmail): void {
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("email address is empty of insecure"));
		}
		$this->profileEmail = $newProfileEmail;
	}


	/**
	 * accessor method
	 * @return string value of $profileHash
	 */
	public function getProfileHash() {
		return $this->profileHash;
	}

	/**
	 * @param string $profileHash \
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setProfileHash(string $profileHash) {
		$this->profileHash = $profileHash;
	}

	/**
	 * accessor method
	 * @return int value of profile is owner
	 */
	public function getProfileIsOwner(): int {
		return $this->profileIsOwner;
	}

	/**
	 * mutator method
	 * @param int $newProfileIsOwner
	 * @return int value of $newProfileIsOwner
	 */
	public function setProfileIsOwner($newProfileIsOwner): void {
		$this->profileIsOwner = $newProfileIsOwner;
	}

	/**
	 * accessor method
	 *
	 * @return string value of profile first name
	 */
	public function getProfileFirstName(): string {
		return $this->profileFirstName;
	}


	/**
	 * mutator method
	 * @param string value of $newProfileFirstName
	 * @throws \InvalidArgumentException if $newProfileFirstName is not a string or insecure
	 * @throws \RangeException if $newProfileFirstName is > 64 characters
	 */
	public function setProfileFirstName(string $newProfileFirstName) {
		$newProfileFirstName = trim($newProfileFirstName);
		$newProfileFirstName = filter_var($newProfileFirstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileFirstName) === true) {
			throw(new \InvalidArgumentException("first name content is invalid"));
		}
		if(strlen($newProfileFirstName) > 64) {
			throw(new \RangeException("first name content is too long"));
		}
		$this->profileFirstName = $newProfileFirstName;
	}


	/**
	 * accessor method
	 * @return string value of profile last name
	 */
	public function getProfileLastName(): string {
		return $this->profileLastName;
	}

	/**
	 * mutator method
	 *
	 * @param string value of $profileLastName
	 * @throws \InvalidArgumentException if $newProfileLastName is not a string or insecure
	 * @throws \RangeException if $newProfileLastName is > 64 characters
	 */
	public function setProfileLastName(string $newProfileLastName): void {
		$newProfileLastName = trim($newProfileLastName);
		$newProfileLastName = filter_var($newProfileLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileLastName) === true) {
			throw(new \InvalidArgumentException("last name content is invalid"));
		}
		if(strlen($newProfileLastName) > 64) {
			throw(new \RangeException("last name content is too long"));
		}
		$this->profileLastName = $newProfileLastName;
	}

	/**
	 * accessor method
	 * @return string value of profile user name
	 */
	public
	function getProfileUserName(): string {
		return $this->profileUserName;
	}

	/**
	 * mutator method
	 * ````````````````````````````````````````````````````\   `       *
	 * @param string of $newProfileUserName
	 * @throws \InvalidArgumentException if $newProfileUserName is not a string or insecure
	 * @throws \RangeException if $newProfileUsername is > 64 characters
	 * @throws \TypeError if $newProfileUsername is not a string
	 */
	public function setProfileUserName(string $newProfileUserName) {
		$newProfileUserName = trim($newProfileUserName);
		$newProfileUserName = filter_var($newProfileUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileUserName) === true) {
			throw(new \InvalidArgumentException("user name is empty or invalid"));
		}
		if(strlen($newProfileUserName) > 64) {
			throw(new \InvalidArgumentException("user name is too long"));
		}
		$this->profileUserName = $newProfileUserName;
	}


	/**
	 * PDO's
	 */

	/**
	 * inserts profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo): void {
		$query = "INSERT INTO profile(profileId, profileActivationToken, profileEmail, profileHash, profileIsOwner, profileFirstName, profileLastName, profileUserName) VALUES(:profileId, :profileActivationToken, :profileEmail, :profileHash, :profileIsOwner,:profileFirstName,:profileLastName,:profileUserName)";
		$statement = $pdo->prepare($query);
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileIsOwner" => $this->profileIsOwner, "profileFirstName" => $this->profileFirstName, "profileLastName" => $this->profileLastName, "profileUserName" => $this->profileUserName];
		$statement->execute($parameters);
	}


	/*
	 * deletes profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL error occurs
	 * @throws \TypeError if $pdo if PDO is not a connection object
	 */
	public function delete(\PDO $pdo): void {
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		$parameters = ["profileId" => $this->profileId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL error occurs
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo): void {
		$query = "UPDATE profile SET profileId = :profileId, profileActivationToken = :profileActivationToken, profileEmail = :profileEmail, profileHash = :profileHash, profileIsOwner = :profileIsOwner, profileFirstName = :profileFirstName, profileLastName = :profileLastName, profileUserName = :profileUserName WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileIsOwner" => $this->profileIsOwner, "profileFirstName" => $this->profileFirstName, "profileLastName" => $this->profileLastName, "profileUserName" => $this->profileUserName];
		$statement->execute($parameters);
	}

	/*
	 * gets the profile by profile id
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileId profile id to search for
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 */
	public static function getProfileByProfileId(\PDO $pdo, string $profileId): ?Profile {
	    //sanitize the profile id before searching
		try {
			$profileId = self::ValidateUuid($profileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileHash, profileIsOwner, profileFirstName, profileLastName, profileUserName FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		$parameters = ["profileId" => $profileId->getBytes()];
		$statement->execute($parameters);
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileHash"], $row["profileIsOwner"], $row["profileFirstName"], $row["profileLastName"], $row["profileUserName"]);
			}
		} catch(\Exception $exception) {
		    // if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/*
	 *
	 */
	public function getProfileByProfileUserName(\PDO $pdo, $profileUserName): \SplFixedArray {
		$profileUserName = trim($profileUserName);
		$profileUserName = filter_var($profileUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileUserName) === true) {
			throw(new \PDOException("user name is invalid"));
		}
		$profileUserName = str_replace("_", "\\_", str_replace("%", "\\%", $profileUserName));
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileHash, profileIsOwner, profileFirstName, profileLastName, profileUsername FROM profile WHERE profileUserName = :profileUserName";
		$statement = $pdo->prepare($query);
		$profileUserName = "%$profileUserName%";
		$parameters = ["profileUserName" => $profileUserName];
		$statement->execute($parameters);
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileHash"], $row["profileIsOwner"], $row["profileFirstName"], $row["profileLastName"], $row["profileUserName"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

	/*
	 *
	 */
	public function getProfileByProfileEmail(\PDO $pdo, $profileEmail): ?Profile {
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileEmail) === true) {
			throw(new \PDOException("email is invalid"));
		}
		$profileEmail = str_replace("_", "\\_", str_replace("%", "\\%", $profileEmail));
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileHash, profileIsOwner, profileFirstName, profileLastName, profileUsername FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);
		$parameters = ["$profileEmail" => $profileEmail];
		$statement->execute($parameters);
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileHash"], $row["profileIsOwner"], $row["profileFirstName"], $row["profileLastName"], $row["profileUserName"]);
			}
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/*
	 *
	 */
	public function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken): ?Profile {
		$profileActivationToken = trim($profileActivationToken);
		$profileActivationToken = filter_var($profileActivationToken, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileActivationToken) === true) {
			throw(new \PDOException("profile activation token is invalid"));
		}
		$profileEmail = str_replace("_", "\\_", str_replace("%", "\\%", $profileActivationToken));
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileHash, profileIsOwner, profileFirstName, profileLastName, profileUsername FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		$parameters = ["$profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileHash"], $row["profileIsOwner"], $row["profileFirstName"], $row["profileLastName"], $row["profileUserName"]);
			}
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/*
	 * UNNECESSARY CODE
	 *
	public function getAllProfiles(\PDO $pdo) : \SplFixedArray {
		$query = "SELECT profileId, profileActivationToken, profileEmail, profileHash, profileIsOwner, profileFirstName, profileLastName, profileUsername FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);
		$statement->execute();
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !==false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileEmail"], $row["profileHash"], $row["profileIsOwner"], $row["profileFirstName"], $row["profileLastName"], $row["profileUserName"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
		}
*/

	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		$fields["profileId"] = $this->profileId->toString();
		return ($fields);
	}
}
