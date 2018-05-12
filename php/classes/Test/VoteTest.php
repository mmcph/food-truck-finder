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
    //todo finish writing mocked truck
        //create and insert the mocked truck
        $this->truck = new Truck(generateUuid4(), $this->truck->getTruckId(), "????")

        // create and insert the mocked vote
        $this->vote = new Vote(generateUuid4(), $this->profile->getProfileId(), "PHPUnit vote test passing");
        $this->vote->insert($this->getPDO());
    }
    /**
     *
     *
     *  test inserting a valid Vote and verify that the actual mySQL data matches
     *
     *
     *
     */
    public function testInsertValidVote() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("like");

        // create a new Vote and insert to into mySQL

    }

    /**
     * test creating a Vote and then deleting it
     */
    public function testDeleteValidVote () {

    }

    /**
     * test inserting a Vote and re-grabbing it from mySQL
     */
    public function testGetValidVoteByProfileIdAndTruckId () {

    }

    /**
     * test grabbing a Vote that does not exist
     */
    //todo does this need to be tested?
    //public function testGetInvalidVoteByProfileIdAndTruckId () {   }


    /**
     * test grabbing a Vote by profile
     */

    public function testGetValidVoteByVoteProfileId () {

    }

    /**
     * test grabbing a Vote by a profile that has not made any votes
     */

    public function testGetInvalidVoteByVoteProfileId () {

    }

    /**
     * test grabbing a Vote by truck
     */

    public function testGetValidVoteByVoteTruckId () {

    }

    /**
     * test grabbing a Vote by truck that has no votes
     */
    public function testGetInvalidVoteByVoteTruckId () {
    }






}