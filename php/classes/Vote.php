<?php
namespace Edu\Cnm\FoodTruck;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

/**
 * This is the class for our attribute of Vote where users can up or down vote a food truck.
 * It is an intersection table (composite entity) between Truck and Vote (a 1-to-m relationship)
 * and Profile and Vote (a 1-to-1 relationship)
 *
 * @author Yvette Johnson-Rodgers <itsyvejr@gmail.com>
 * @version 1.0
 **/
class Vote implements \JsonSerializable {
    use ValidateUuid;
    /**
     * id for profile that is casting this vote; this is a primary key for the class
     * (and a foreign key referencing the profileId)
     * @var Uuid $voteProfileId
     **/
    private $voteProfileId;
    /**
     * id of the truck that is being voted on; this is a primary key for the class
     * this is a foreign key referencing the truckId
     * @var Uuid $voteTruckId
     **/
    private $voteTruckId;
    /**
     * the value of the vote, which will be either an up or down vote
     * @var $voteValue
     **/
    private $voteValue;
    /**
     * constructor for this Vote
     * @param string|Uuid $newVoteProfileId id of the profile casting the vote
     * @param string|Uuid $newVoteTruckId id of the truck receiving the vote
     * @param int $newVoteValue for the value of the vote
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
     * @throws \Exception if some other exception is thrown
     * @throws \TypeError if data types violate type hints
     *
     **/
    public function __construct( $newVoteProfileId, $newVoteTruckId, int $newVoteValue) {
        //
        try {
            $this->setVoteProfileId($newVoteProfileId);
            $this->setVoteTruckId($newVoteTruckId);
            $this->setVoteValue($newVoteValue);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            // determine what exception type was thrown
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }
    /**
     * accessor method for profile Id
     *
     * @return Uuid value for profile Id
     **/
    public function getVoteProfileId () : Uuid {
        return($this->voteProfileId);
    }
    /**
     * mutator method for profile Id
     *
     * @param string $newVoteProfileId new value of vote id
     * @throws \InvalidArgumentException if $newVoteProfileId is if data types are not valid
     * @throws \RangeException if $newVoteProfileId is not positive
     * @throws \Exception if $newVoteProfileId is if some other exception is thrown
     * @throws \TypeError if $newProfileId is not an integer
     **/
    public function setVoteProfileId ($newVoteProfileId) : void {
        try {
            $uuid = self::validateUuid($newVoteProfileId);
        } catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        // convert and store the profile Id
        $this->voteProfileId = $uuid;
    }
     /**
      * accessor method for truck Id
      *
      * @return Uuid value for truck Id
     **/
    public function getVoteTruckId () : Uuid {
        return($this->voteTruckId);
    }
    /**
     * mutator method for truck Id
     *
     * @param string $newVoteTruckId new value of vote
     * @throws \InvalidArgumentException if $setVoteTruckId data types are not valid
     * @throws \RangeException if $newProfileId is not positive
     * @throws \Exception if if some other exception is thrown
     * @throws \TypeError if $newProfileId is not an integer
     **/
    public function setVoteTruckId ($newVoteTruckId) : void {
        try {
            $uuid = self::validateUuid($newVoteTruckId);
        }  catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        // convert and store the truck Id
        $this->voteTruckId = $uuid;
    }
    /**
     * accessor method for vote value
     *
     * @return number for vote value
     **/
    public function getVoteValue () : int {
        return($this->voteValue);
    }
    /**
     * mutator method for vote value
     *
     * @param int $newVoteValue value of vote
     * @throws \InvalidArgumentException if $newVoteValue  data types are not valid
     **/
    public function setVoteValue (int $newVoteValue): void {
        if($newVoteValue !== -1 || $newVoteValue !== 1) {
            throw(new \InvalidArgumentException("vote value is incorrect"));
        }
        // convert and store the vote value
        $this->voteValue = $newVoteValue;
    }
    /**
     * inserts this Vote into mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     **/
    public function insert(\PDO $pdo) : void {
        // create a query template
        $query = "INSERT INTO vote (voteProfileId, voteTruckId, voteValue) VALUES (:voteProfileId, :voteTruckId, :voteValue)";
        $statement = $pdo->prepare($query);
        // bind the member variables to the place holders in the template
        $parameters = ["voteProfileId" =>
            $this->voteProfileId->getBytes(), "voteTruckId" => $this->voteTruckId->getBytes(), "voteValue" => $this->voteValue];
        $statement->execute($parameters);
        }
    /**
     * deletes this Vote from mySQL
     *
     * @param \PDO $pdo PDO connection object
     * @throws \PDOException when mySQL related errors occur
     */
    public function delete(\PDO $pdo) : void {
        // create query table
        $query = "DELETE FROM vote WHERE voteProfileId = :voteProfileId AND voteTruckId = :voteTruckId";
        $statement = $pdo->prepare($query);
        //bind the member variables to the placeholders in the template
        $parameters = ["voteProfileId" =>$this->voteProfileId->getBytes(), "voteTruckId" => $this->voteTruckId->getBytes()];
        $statement->execute($parameters);
    }
    /**
     *
     * gets the Vote by profile id
     * @param \PDO $pdo PDO connection object
     * @param \PDO Uuid|string $VoteProfileId to search by
     * @return \SplFixedArray SplFixedArray of Votes found or null if not found
     * @throws \PDOException when mySQL related errors occur
     */
    public static function getVotesByVoteProfileId (\PDO $pdo, $voteProfileId): \SplFixedArray {
        try {
            $voteProfileId = self::validateUuid($voteProfileId);
        } catch(\InvalidArgumentException | \RangeException |\Exception |\TypeError $exception){
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        // create query template
        $query = "SELECT voteProfileId, voteTruckId, voteValue FROM vote WHERE voteProfileId = :voteProfileId";
        $statement = $pdo->prepare($query);
        // bind the member variables to the place holder in the template
        $parameters = ["voteProfileId" => $voteProfileId->getBytes()];
        $statement->execute($parameters);
        // build the array of votes
        $votes = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !==false) {
            try {
                $vote = new Vote($row["voteProfileId"], $row["voteTruckId"], $row ["voteValue"]);
                $votes[$votes->key()] = $vote;
                $votes->next();
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
                throw(new \PDOException($exception->getMessage(),0, $exception));
            }
        }
        return ($votes);
    }
    /**
     *
     * gets Vote by truck Id
     * @param \PDO $pdo PDO connection object
     * @param Uuid| string $voteTruckId to search by
     * @return \SplFixedArray SplFixedArray of Votes found or null if not found
     * @throws \InvalidArgumentException if data types are not valid
     * @throws \RangeException if out of range
     * @throws \Exception if some other exception is thrown
     * @throws \TypeError if not a UUID
     * @throws \PDOException when mySQL related errors occur
     *
     **/
    public static function getVoteByTruckId (\PDO $pdo, $voteTruckId): \SplFixedArray {
        try {
            $voteProfileId = self::validateUuid($voteTruckId);
        } catch(\InvalidArgumentException | \RangeException |\Exception |\TypeError $exception){
            throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
        // create query template
        $query = "SELECT voteProfileId, voteTruckId, voteValue FROM vote WHERE voteProfileId = :voteProfileId";
        $statement = $pdo->prepare($query);
        // bind the member variables to the place holder in the template
        $parameters = ["voteTruckId"=> $voteTruckId->getBytes()];
        $statement->execute($parameters);
        // build the array of votes
        $votes = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while(($row = $statement->fetch()) !==false) {
            try {
                $vote = new vote($row["voteProfileId"], $row["voteTruckId"], $row ["voteValue"]);
                $votes[$votes->key()] = $vote;
                $votes->next();
            } catch(\Exception $exception) {
                // if the row couldn't be converted, rethrow it
            } throw(new \PDOException($exception->getMessage(), 0, $exception));
        }
    }
    /**
     *
     * @param \PDO $pdo connection object
     * @param Uuid|string $voteProfileId $voteTruckId to search for
     * @return vote to mySQL
     * @throws \PDOException  when mySQL related errors occur
     **/
    public static function getVoteByVoteProfileIdAndVoteTruckId (\PDO $pdo, $voteProfileId, $voteTruckId): ?Vote {
        // create query template
        $query = "SELECT voteProfileId, voteTruckId FROM  vote WHERE voteProfileId = :voteProfileId AND voteTruckId = :voteTruckId";
        $statement = $pdo->prepare($query);
        // bind the vote from mySQL
        try {
            $vote = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if($row !== false) {
                $vote = new vote($row["voteProfileId"], $row["voteTruckId"]);
            }
        } catch(\Exception $exception) {
            // if the row couldn't be converted, rethrow it
            throw (new \PDOException($exception->getMessage(),0, $exception));
        }
        return ($vote);
    }
    /**
     * formats the state variables for JSON serialization
     *
     * @return array resulting state variables to serialize
     **/
    public function jsonSerialize() {
        $fields = get_object_vars($this);
        //format the date so that the front end can consume it
        $fields["voteProfileId"] = $this->voteProfileId;
        $fields["voteTruckId"] = $this->voteTruckId;
        $fields["voteValue"] = $this->voteValue;
        return ($fields);
    }
}

