<?php

namespace Edu\Cnm\food-truck-finder;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;


/**
 * Trait ValidateUuid
 * @package Edu\Cnm\food-truck-finder
 *
 * This trait will validate proper UUIDs for the following formats:
 * -human readable string (36 bytes)
 * -binary string (16 bytes)
 * -
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
 * Class profile
 *
 * This class will serve as a platform in which users will utilize to gain access to "registered user" abilities, such as
 * being designated as a "vendor" or "customer"
 *
 * @package Edu\Cnm\food-truck-finder
 * @author G. Cordova
 */
class profile  implements /JsonSerializable {
		/**
		 * UNIQUE
		 * id for profile
		 * PRIMARY key
		 * @var Uuid $profileId
		 */
		private
		$profileId;
		/**
		 * UNIQUE
		 * email for profile
		 * @var string $profileEmail
		 */
		private
		$profileEmail;

		/**
		 * hash for profile (pw)
		 * @var mixed $profileHash
		 */
		private
		$profileHash;

		/**
		 * indication of whether or not the profile is one of a vendor
		 * @var bool $profileIsOwner
		 */
		private
		$profileIsOwner;

		/**
		 * first name of profile user
		 * @var string $profileFirstName
		 */
		private
		$profileFirstName;

		/**
		 * last name of profile user
		 * @var string $profileLastName
		 */
		private
		$profileLastName;

		/**
		 * UNIQUE
		 * user name of profile (handle)
		 * @var string $profileUserName
		 */
		private
		$profileUserName;


		public
		function __construct($newProfileId, string $newProfileEmail, string $newProfileHash, bool $newProfileIsOwner, string $newProfileFirstName, string $newprofileLastName, string $newProfileUserName)
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileEmail($newProfileEmailId);
			$this->setProfileHash($newProfileHash);
			$this->setProfileIsOwner($newProfileIsOwner);
			$this->setProfileFirstName($newProfileFirstName);
			$this->setProfileLastName($newProfileLastName);
			$this->setProfileUserName($newProfileUserName);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}


		/**
		 * accessor method
		 *
		 * @return Uuid | string of profile id
		 */
	public function getProfileId() : Uuid {
		return $this->profileId;
}

	/**
	 *mutator method
	 *
	 * @param Uuid | string value of  $newProfileId
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not a uuid or string
	 */
	public function setProfileId($newProfileId) : void {
	try {
		$uuid = self::validateUuid($newProfileId);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	$this->profileId = $uuid;
}

	/**
	 * accessor method
	 * @return string value of profile email
	 */
	public function getProfileEmail() : string {
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
	public function setProfileEmail(string $newProfileEmail) : void {
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
	 * @param string $profileHash\
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setProfileHash($profileHash) {
	$this->profileHash = $profileHash;
}

	/**
	 * accessor method
	 * @return int value of profile is owner
	 */
	public function getProfileIsOwner() : int {
	return $this->profileIsOwner;
}

	/**
	 * @param int $profileIsOwner
	 */
	public function setProfileIsOwner($newProfileIsOwner) : int {
	$this->profileIsOwner = $newProfileIsOwner;
}

	/**
	 * accessor method
	 *
	 * @return string value of profile first name
	 */
	public function getProfileFirstName() : string {
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
	public function getProfileLastName() : string {
	return $this->profileLastName;
}

	/**
	 * mutator method
	 *
	 * @param string value of $profileLastName
	 * @throws \InvalidArgumentException if $newProfileLastName is not a string or insecure
	 * @throws \RangeException if $newProfileLastName is > 64 characters
	 */
	public function setProfileLastName(string $newProfileLastName) : void {
	$newProfileLastName = trim($newProfileLastName);
	$newProfileLastName = filter_var($newProfileLastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($newProfileLastName) === true) {
		throw(new \InvalidArgumentException("last name content is invalid"));
	}
	if (strlen($newProfileLastName) > 64) {
		throw(new \RangeException("last name content is too long"));
		$this->profileLastName = $newProfileLastName;
	}

	/**
	 * accessor method
	 * @return string value of profile user name
	 */
	public function getProfileUserName() : string {
		return $this->profileUserName;
	}

	/**
	 * mutator method
	 *
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
	public function insert(\PDO $pdo) : void {
		$query = "INSERT INTO profile(profileId, profileEmail, profileHash, profileIsOwner, profileFirstName, profileLastName, profileUserName) VALUES(:profileId, :profileEmail, :profileHash, :profileIsOwner,:profileFirstName,:profileLastName,:profileUserName)";
		$statement = $pdo->prepare($query);

		$parameters = ["profileId" => $this->profileId->getBytes(), "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileIsOwner" => $this->profileIsOwner, "profileFirstName" => $this->profileFirstName, "profileLastName" => $this->profileLastName, "profileUserName" => $this->profileUserName];
		$statement->execute($parameters);
	}


	/*
	 * deletes profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL error occurs
	 * @throws \TypeError if $pdo if PDO is not a connection object
	 */
	public function delete(\PDO $pdo) : void {
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
	public function update(\PDO $pdo) : void {
		$query = "UPDATE profile SET profileId = :profileId, profileEmail = :profileEmail, profileHash = :profileHash, profileIsOwner = :profileIsOwner, profileFirstName = :profileFirstName, profileLastName = :profileLastName, profileUserName = :profileUserName WHERE profileId = profileId";
		$statement = $pdo->prepare($query);

		$parameters = ["profileId" => $this->profileId->getBytes(), "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileIsOwner" => $this->profileIsOwner, "profileFirstName" => $this->profileFirstName, "profileLastName" => $this->profileLastName, "profileUserName" => $this->profileUserName];
		$statement->execute($parameters);
	}




