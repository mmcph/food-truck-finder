<?php
namespace Edu\Cnm\TacoTruck\Test

use Edu\Cnm\FoodTruck\{Vote, Profile, Truck};
use function Sodium\randombytes_random16;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirnam(__DIR__, 2) . "lib/uuid.php");

/**
 * Full PHPUnit test for the Vote class
 *
 * This is a complete PHPUnit test of the Vote class. It is complete because it tests all mySQL/PDO enabled methods
 * for both valid and invalid inputs
 *
 * @see Vote
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 *
 **/

class VoteTest extends TacoTruckTest {
    /**
     * Profile that created the Vote; this is for foreign key relations
     * @var Vote $vote
     **/
    private $profile;
    /**
     * this is the truck being voted on
     */
    private $truck;
    /**
     * valid hash to use
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

        // create and insert the mocked profile
        $this->profile = new Profile(generateUuid4(), test@phpunit.de, $this->VALID_HASH, newIsOwner 1, newFirstName "Misty", newLastName "Smith", newUserName "ihearttacos";
        $this->profile->insert($this->getPDO());

        // create and insert the mocked vote
        $this->vote = new Vote(generateUuid4(), $this->profile->getProfileId(), "PHPUnit vote test passing");
        $this->vote->insert($this->getPDO());
    }
}