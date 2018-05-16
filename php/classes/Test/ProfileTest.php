<?php
namespace Edu\Cnm\FoodTruck\Test;
use Edu\Cnm\FoodTruck\Profile;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because it tests all mySQL/PDO enabled methods
 * for both valid and invalid inputs
 *
 * @see Profile
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 *
 **/
class ProfileTest extends TacoTruckTest {
	/*
	 * placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 **/
	private $VALID_ACTIVATION;
	/**
	 * valid email to use
	 * @var string $VALID_EMAIL
	 */
	private $VALID_EMAIL = "test@phpunit.de";
	/**
	 * valid hash to use
	 * @var $VALID_HASH
	 **/
	private $VALID_HASH;
	/**
	 * @var int $VALID_ISOWNER
	 **/
	private $VALID_ISOWNER = 1;
	/**
	 * valid first name to use
	 * @var $VALID_FIRSTNAME
	 **/
	private $VALID_FIRSTNAME = "Marika";
	/**
	 * valid last name to use
	 * @var string $VALID_LASTNAME
	 **/
	private $VALID_LASTNAME = "Johnson";
	/**
	 * valid last name to use when we change the last name
	 * @var $VALID_LASTNAME2
	 */
	private $VALID_LASTNAME2 = "Johnson-Rodgers"
    /**
	  * valid username to use
	  * @var string $VALID_USERNAME
	  **/
    private $VALID_USERNAME = "Omnomnom";
    /**
	  *
	  **/
    public final function setUp(): void {
		 parent::setUp();
		 $password = "strongpassword";
		 $this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		 $this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	 }
    /**
	  * test inserting a valid Profile and verify that the actual mySQL data matches
	  */
    public function testInsertValidProfile(): void {
		 // count the number of rows and save it for later
		 $numRows = $this->getConnection()->getRowCount("profile");
		 $profileId = generateUuidV4();
		 $profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_ISOWNER, $this->VALID_FIRSTNAME, $this->VALID_LASTNAME, $this->VALID_USERNAME);
		 $profile->insert($this->getPDO());
		 // grab the data from mySQL and enforce the fields match our expectations
		 $pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		 $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		 $this->assertEquals($pdoProfile->getProfileId(), $profileId);
		 $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		 $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		 $this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		 $this->assertEquals($pdoProfile->getProfileIsOwner(), $this->VALID_ISOWNER);
		 $this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_FIRSTNAME);
		 $this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_LASTNAME);
		 $this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_LASTNAME);
		 $this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERNAME);
	 }
    /**
	  * test inserting a profile, editing it, and then updating it
	  */
    public function testUpdateValidProfile(): void {
		 // count the number of rows and save it for later
		 $numRows = $this->getConnection()->getRowCount("profile");
		 // create a new Profile and insert into mySQL
		 $profileId = generateUuidV4();
		 $profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_ISOWNER, $this->VALID_FIRSTNAME, $this->VALID_LASTNAME, $this->VALID_USERNAME);
		 $profile->insert($this->getPDO());
		 // edit the Profile and update it in my SQL
		 $profile->setProfileLastName($this->VALID_LASTNAME2);
		 $profile->insert($this->getPDO());
		 // grab the data from mySQL and enforce the fields match our expectations
		 $pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		 $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		 $this->assertEquals($pdoProfile->getProfileId(), $profileId);
		 $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		 $this->assertEquals($pdoProfile->getProfileByProfileEmail(), $this->VALID_EMAIL);
		 $this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		 $this->assertEquals($pdoProfile->getProfileIsOwner(), $this->VALID_ISOWNER);
		 $this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_FIRSTNAME);
		 $this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_LASTNAME2);
		 $this->assertEquals($pdoProfile->getProfileByProfileUserName(), $this->VALID_USERNAME);
	 }
	 /**
      * test creating a Profile and then deleting it
      */
	 public function testDeleteValidProfile(): void {
         // count the number of rows and save it for later
         $numRows = $this->getConnection()->getRowCount("profile");
         $profileId = generateUuidV4();
         $profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_ISOWNER, $this->VALID_FIRSTNAME, $this->VALID_LASTNAME, $this->VALID_USERNAME);
         $profile->insert($this->getPDO());
         // delete the profile from mySQL
         $this->assertEquals($numRows + 1, $this->getConnection()->getConnection()->getRowCount("profile"));
         $profile->delete($this->getPDO());
         // grab the data from mySQL and enforce the Profile does not exist
         $pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
         $this->assertNull($pdoProfile);
         $this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
     }
    /**
     * test grabbing a profile that does not exist
     */
    public function getInvalidProfileByProfileId (): void {
        // test grabbing for a profile id that does not exist
        $fakeProfileId = generateUuidV4();
        $profile = Profile::getProfileByProfileId($this->getPDO(), $fakeProfileId);
        $this->assertNull($profile);
    }
    /**
     * test grabbing a profile by the user name
     */
    public function getValidProfileByProfileUserName (): void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("profile");
        $profileId = generateUuidV4();
        $profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_ISOWNER, $this->VALID_HASH, $this->VALID_ISOWNER, $this->VALID_FIRSTNAME, $this->VALID_LASTNAME, $this->VALID_USERNAME);
        $profile->insert($this->getPDO());
        // grab the data from mySQL
        $results = Profile::getProfileByProfileUserName ($this->getPDO(), $this->VALID_USERNAME);
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
        // enforce no other objects are bleeding into profile
        $this->assertContainsOnlyInstancesOf("Edu\\CNM\\FoodTruck\\Profile", $results);
        // enforce the results meet the expectations
        $pdoProfile = $results[0];
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
        $this->assertEquals($pdoProfile->getProfileId(), $profileId);
        $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
        $this->assertEquals($pdoProfile->getProfileByProfileEmail(), $this->VALID_EMAIL);
        $this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
        $this->assertEquals($pdoProfile->getProfileIsOwner(), $this->VALID_ISOWNER);
        $this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_FIRSTNAME);
        $this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_LASTNAME2);
        $this->assertEquals($pdoProfile->getProfileByProfileUserName(), $this->VALID_USERNAME);
    }
    /**
     *
     */
    public function getInvalidProfileByProfileUserName () : void {
        // test grabbing for a profile id by a profile user name that does not exist
        $fakeUserName = "Heidi Martinez";
        $profile = Profile::getProfileByProfileUserName($this->getPDO(),$fakeUserName);
        $this->assertNull($profile);
    }
    /*
     *
     * getValidProfileByProfileEmail
     * getInvalidProfileByProfileEmail
     * getValidProfileByProfileActivationToken
     * getInvalidProfileByProfileActivationToken , quick note to self, will delete later
     *
     */
    public function testGetInvalidProfileByProfileActivationToken(): void {
        $profile = Profile::getProfileByProfileActivationToken($this->getPDO(), "ef3b26bb428e4b9db3cc4d9b6955efd8");
        $this->assertNull($profile);
    }
    /**
     *
     */
    public function testGetValidProfileByProfileActivationToken(): void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("profile");
        $profileId = generateUuidV4();
        $profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_ISOWNER, $this->VALID_FIRSTNAME, $this->VALID_LASTNAME, $this->VALID_USERNAME);
        $profile->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoProfile = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
        $this->assertEquals($pdoProfile->getProfileId(), $profileId);
        $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
        $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
        $this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
        $this->assertEquals($pdoProfile->getProfileIsOwner(), $this->VALID_ISOWNER);
        $this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_FIRSTNAME);
        $this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_LASTNAME);
        $this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERNAME);
    }
    /**
     *
     */
    public function getValidProfileByProfileEmail () : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("profile");
        $profileId = generateUuidV4();
        $profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_ISOWNER, $this->VALID_FIRSTNAME, $this->VALID_LASTNAME, $this->VALID_USERNAME);
        $profile->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoProfile = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
        $this->assertEquals($pdoProfile->getProfileId(), $profileId);
        $this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
        $this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
        $this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
        $this->assertEquals($pdoProfile->getProfileIsOwner(), $this->VALID_ISOWNER);
        $this->assertEquals($pdoProfile->getProfileFirstName(), $this->VALID_FIRSTNAME);
        $this->assertEquals($pdoProfile->getProfileLastName(), $this->VALID_LASTNAME);
        $this->assertEquals($pdoProfile->getProfileUserName(), $this->VALID_USERNAME);
}
/**
 *
 */
public function getInvalidProfileByProfileEmail () : void {
        $profile = Profile::getProfileByProfileEmail($this->getPDO(), "invalid@doesnt.exist");
        $this->assertNull($profile);
    }
}































