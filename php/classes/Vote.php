<?php
namespace Edu\Cnm\FoodTruck;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * This is the class for our attribute of Vote
 *
 *
 * @author Yvette Johnson-Rodgers <itsyvejr@gmail.com>
 * @version 1.0
 **/
class Vote implements \JsonSerializable {
    use ValidateUuid;
    /**
     * id for profile that is casting this vote; this is a primary key for the class
     * this is a foreign key referencing the profileId
     **/
    private $voteProfileId;
    /**
     * id of the truck that is being voted on; this is a primary key for the class
     * this is a foreign key referencing the truckId
     **/
    private $voteTruckId;
    /**
     * the value of the vote, which will be either an up or down vote
     **/
    private $voteValue;
    /**
     * constructor for this Vote
     **/
    public function __construct($newVoteProfileId, $newVoteTruckId, $newVoteValue) {
        try {
            $this->setVoteProfileId);
            $this->setVoteTruckId);
            $this->setVoteValue);
        }
            // determine what exception type was thrown
        catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }
    /**
     * accessor method for profile Id
     * @return Uuid value for profile Id
     **/
    public function getVoteProfileId () : Uuid {
        return($this->voteProfileId);
    }
    /**
     * mutator method for profile Id
     **/
    public function setVoteProfileId () : void {
        try {
            $uuid = self::validateUuid($newVoteProfileId)
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        // convert and store the profile Id
        $this->VoteProfileId = $uuid;
    }
     /**
      * accessor method for truck Id
      * @return Uuid value for truck Id
     **/
    public function getVoteTruckId () : Uuid {
        return($this->voteTruckId);
    }
    /**
     * mutator method for truck Id
     **/
    public function setVoteTruckId () : void {
        try {
            $uuid = self::validateUuid($newVoteTruckId)
        }  catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        // convert and store the truck Id
        $this->VoteTruckId = $uuid;
    }
    /**
     * accessor method for vote value
     * @return number for vote value
     **/
    public function getVoteValue () : int {
        return($this->voteValue);
    }
    /**
     * mutator method for vote value
     **/
    public function setVoteValue (int $newVoteValue): void {
        if($newVoteValue !== -1 || $newVoteValue !== 1) {
            throw(new \InvalidArgumentException("vote value is incorrect"));
        }
        // store the vote value
        $this->voteValue = $newVoteValue;
    }
    /**
     *inserts this Vote into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     **/
    public function insert(\PDO $pdo) : void {
        // create a query template
        $query = "INSERT INTO `vote` (voteProfileId, voteTruckId, voteValue) VALUES (:voteProfileId, :voteTruckId, :voteValue)";
        $statement = $pdo->prepare($query);
        // bind the member variables to the place holders in the template
        $parameters = ["voteProfileId" =>
            $this->voteProfileId->getBytes(), "voteTruckId" => $this->voteTruckId->getBytes(), "voteValue" => $this->voteValue];
        $statement->execute($parameters);
        }
    }
