<?php
namespace Edu\Cnm\FoodTruck\Test;
use Edu\Cnm\FoodTruck\{Vote, Profile, Truck};
use function Sodium\randombytes_random16;
// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");
// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
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
    /*
     * Profile that created the Vote; this is for foreign key relations
     * @var Profile $profile
     **/
    private $profile;
    /**
     * this is the truck being voted on
     * @var Truck $truck
     */
    private $truck;
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
	 * valid VoteValue for testing purposes
	 */
	protected $VALID_VOTEVALUE = 1;

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
        $this->profile = new Profile(generateUuidV4(), $this->VALID_ACTIVATION, "hi@gmail.com", $this->VALID_HASH, 1, "my name is", "slim shady", "eminem");
        $this->profile->insert($this->getPDO());

        //create and insert the mocked truck
        $this->truck = new Truck (generateUuidV4(), $this->profile->getProfileId(),"I am a happy little truck.", 1, 35.0772, 106.6614, "LegenDairy", "5058591234", "https://phpunit.de/");
        $this->truck->insert($this->getPDO());
        // create and insert the mocked vote
//        $this->vote = new Vote(generateUuidV4(), $this->profile->getProfileId(), $this->VALID_VOTEVALUE);
//        $this->vote->insert($this->getPDO());
    }
    /**
     *
     *  test inserting a valid Vote and verify that the actual mySQL data matches
     *
     */
    public function testInsertValidVote() : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("vote");

        // create a new Vote and insert to into mySQL
        $vote = new Vote($this->profile->getProfileId(), $this->truck->getTruckId(), $this->VALID_VOTEVALUE);
        $vote->insert($this->getPDO());

       // grab the data from mySQL and enforce the fields match our expectations
        $pdoVote = Vote::getVoteByVoteProfileIdAndVoteTruckId($this->getPDO(), $this->profile->getProfileId(), $this->truck->getTruckId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
        $this->assertEquals($pdoVote->getVoteProfileId(), $this->profile->getProfileId());
        $this->assertEquals($pdoVote->getVoteTruckId(), $this->truck->getTruckId());
    }
    /**
     * test creating a Vote and then deleting it
     */
    public function testDeleteValidVote () {
    // count the  number of rows and save it for later
    $numRows = $this->getConnection()->getRowCount("vote");
    //create a new Vote and insert it into mySQL
    $vote = new Vote($this->profile->getProfileId(), $this->truck->getTruckId(), $this->VALID_VOTEVALUE);
    $vote->insert($this->getPDO());
    // delete the Vote from mySQL
    $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
    $vote->delete($this->getPDO());
    //grab the data from mySQL and enforce the Vote does not exist
    $pdoVote = Vote::getVoteByVoteProfileIdAndVoteTruckId($this->getPDO(),$this->profile->getProfileId(),$this->truck->getTruckId());
    $this->assertNull($pdoVote);
    $this->assertEquals($numRows, $this->getConnection()->getRowCount("vote"));
    }
    /**
     * test inserting a Vote and re-grabbing it from mySQL
     */
    public function testGetValidVoteByProfileIdAndTruckId () {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("vote");
        // create a new Vote and insert into my SQL
        $vote = new Vote($this->profile->getProfileId(), $this->truck->getTruckId(), $this->VALID_VOTEVALUE);
        $vote->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $pdoVote = Vote::getVoteByVoteProfileIdAndVoteTruckId($this->getPDO(),$this->profile->getProfileId(),$this->truck->getTruckId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
        $this->assertEquals($pdoVote->getVoteProfileId(),$this->profile->getProfileId());
        $this->assertEquals($pdoVote->getVoteTruckId(), $this->truck->getTruckId());
        $this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
        //todo question - are we testing the vote values anywhere?
    }
    /**
     * test grabbing Vote that does not exist
     **/
    public function testGetInvalidVoteByProfileIdAndTruckId () {
        // we would expect to get an error when searching for a vote that does not exist
        //todo do we need to assert an error?
        $vote = Vote::getVoteByVoteProfileIdAndVoteTruckId($this->getPDO(), generateUuidV4(), generateUuidV4());
        $this->assertNull($vote);
    }
    /**
     * test grabbing Votes by profile
     */
    public function testGetValidVotesByProfileId () :void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("vote");
        // create a new Vote and insert it into mySQL
        $vote = new Vote($this->profile->getProfileId(), $this->truck->getTruckId(), $this->VALID_VOTEVALUE);
        $vote->insert($this->getPDO());
        // grab the data from mySQL and enforce the fields match our expectations
        $results = Vote::getVotesByVoteProfileId($this->getPDO(), $this->profile->getProfileId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
        $this->assertCount(1, $results);
        // enforce no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruck\\Vote", $results);
        // grab the result from the array and validate it
        $pdoVote= $results[0];
        $this->assertEquals($pdoVote->getVoteProfileId(),$this->profile->getProfileId());
        $this->assertEquals($pdoVote->getVoteTruckId(), $this->truck->getTruckId());
        $this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
    }
    /**
     * test grabbing Votes by a profile that has not made any votes
     */
    public function testGetInvalidVotesByProfileId (): void {
        // try to grab votes that do not exist under this profile
        $vote = Vote::getVotesByVoteProfileId($this->getPDO(), generateUuidV4());
        $this->assertCount(0, $vote);
    }
    /**
     * test grabbing a Vote by truck
     */
    public function testGetValidVotesByTruckId () : void {
        // count the number of rows and save it for later
        $numRows = $this->getConnection()->getRowCount("vote");

        // create a new Vote and insert it into mySQL
        $vote = new Vote($this->profile->getProfileId(), $this->truck->getTruckId(), $this->VALID_VOTEVALUE);
        $vote->insert($this->getPDO());

        // grab the data from mySQL and enforce the fields match our expectations
        $results = Vote::getVoteByVoteTruckId($this->getPDO(), $this->truck->getTruckId());
        $this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
        $this->assertCount(1, $results);

        // enforce no other objects are bleeding into the test
        $this->assertContainsOnlyInstancesOf("Edu\\Cnm\\FoodTruck\\Vote", $results);

        // grab the result from the array and validate it
        $pdoVote = $results[0];
        $this->assertEquals($pdoVote->getVoteProfileId(), $this->profile->getProfileId());
        $this->assertEquals($pdoVote->getVoteTruckId(), $this->truck->getTruckId());
        $this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
    }
    /**
     * test grabbing a Vote by truck that has no votes
     */
    public function testGetInvalidVoteByTruckId () : void {
        // try to grab a vote for a truck that has no votes
        $vote = Vote::getVoteByVoteTruckId($this->getPDO(), generateUuidV4());
        $this->assertCount(0, $vote);
    }

    public function testGetVoteCountByVoteTruckId(): void {
		 // count the number of rows and save it for later
		 $numRows = $this->getConnection()->getRowCount("vote");

		 // create a new Vote and insert it into mySQL
		 $vote = new Vote($this->profile->getProfileId(), $this->truck->getTruckId(), $this->VALID_VOTEVALUE);
//		 $vote = new Vote($this->profile->getProfileId(), $this->truck->getTruckId(), $this->VALID_VOTEVALUE1);
		 $vote->insert($this->getPDO());

		 // grab the data from mySQL and enforce the fields match our expectations
		 $voteCount = Vote::getVoteCountByVoteTruckId($this->getPDO(), $this->truck->getTruckId());


    	$this->assertObjectHasAttribute("upVote", $voteCount);
    	$this->assertObjectHasAttribute("downVote", $voteCount);

	 }
}

