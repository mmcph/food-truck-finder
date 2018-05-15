<?php
namespace Edu\Cnm\FoodTruck\Test;

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

        // create and insert the mocked profile into mySQL
        $this->profile = new Profile (generateUuidV4(), "test@phpunit.de", $this->VALID_HASH, 1, "php", "unit", "phpunit");
        $this->profile->insert($this->getPDO());

        //create and insert the mocked truck
        $this->truck = new Truck (generateUuidV4(), $this->profile->getProfileId(),"I am a happy little truck.", 1, 35.0772, 106.6614, "LegenDairy", 5058596496, "https://phpunit.de/");
        $this->truck->insert($this->getPDO());


        // create and insert the mocked vote
        $this->vote = new Vote(generateUuidV4(), $this->profile->getProfileId(), "PHPUnit vote test passing");
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
        $numRows = $this->getConnection()->getRowCount("vote");

        // create a new Vote and insert to into mySQL
        $vote = new Vote($this->profile->getProfileId(), $this->truck->getTruckId(), $this->voteValue->getVoteValue());
        $vote->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $pdoVote = Vote::getVoteByVoteProfileIdAndVoteTruckId($this->getPDO(), $this->profile->getProfileId(), $this->vote->getTruckId());
        $this->asssertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
        $this->assertEquals($pdoVote->getVoteProfileId(), $this->vote->getProfileId());
        $this->assertEquals($pdoVote->getTruckProfileId(),
        $this->vote->getVoteId());
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