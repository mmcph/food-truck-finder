<?php
namespace Edu\Cnm\FoodTruck\Test;

use Edu\Cnm\FoodTruck\{Profile, Truck};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Favorite class
 *
 * This is a complete PHPUnit test of the Favorite class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Favorite
 * @author Marlon McPherson <mmcpherson5@cnm.edu>
 **/
class FavoriteTest extends TacoTruckTest {
	/**
	 * Profile that created the Favorite; this is for foreign key relations
	 * @var Profile $profile
	 **/
	protected $profile;
	/**
	 * Truck that is favorited; this is for foreign key relations
	 * @var Truck $truck
	 **/
	protected $truck;
    /**
     * valid hash to use
     * @var $VALID_HASH
     **/
    private $VALID_HASH;
    /**
     * valid activationToken to create the profile object to own the test
     * @var string $VALID_ACTIVATION
     **/
    private $VALID_ACTIVATION;
    /**
     *
     * create dependent objects before running each test
     */
    public final function setUp() : void {
        // run the default setUp() method first
        parent::setUp();
        // create a hash for the mocked profile
        $password = "abc123";
        $this->VALID_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
        $this->VALID_ACTIVATION = bin2hex(random_bytes(16));
        // create and insert the mocked profile into mySQL
        $this->profile = new Profile (generateUuidV4(), "test@phpunit.de", $this->VALID_HASH, 1, "php", "unit", "phpunit");
        $this->profile->insert($this->getPDO());
        //create and insert the mocked truck
        $this->truck = new Truck (generateUuidV4(), $this->profile->getProfileId(), "I am a happy little truck.", 1, 35.0772, 106.6614, "LegenDairy", 5058596496, "https://phpunit.de/");
        $this->truck->insert($this->getPDO());
        // create and insert the mocked vote
        $this->vote = new Vote(generateUuidV4(), $this->profile->getProfileId(), 1);
        $this->vote->insert($this->getPDO());
    }
}

