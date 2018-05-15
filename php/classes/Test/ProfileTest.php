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
    private $VALID_ISOWNER = 1 ;
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
    public final function setUp() : void {
    parent::setUp();
    $password = "strongpassword";
    $this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
    $this->VALID_ACTIVATION = bin2hex(random_bytes(16));
    }
    /**
     * test inserting a valid Profile and verify that the actual mySQL data matches
     */
    public function testInsertValidProfile() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("profile");
        $profileId = generateUuidV4();
        $profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_ISOWNER, $this->VALID_FIRSTNAME, $this->VALID_LASTNAME, $this->VALID_USERNAME);
        $profile->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoProfile = Profile::getProfileByProfileId($this->getPDO(),$profile->getProfileId());
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
    public function testUpdateValidProfile() {
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
 * test creating a profile and then deleting it
 */
public function testDeleteValidProfile() : void {
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


















}































