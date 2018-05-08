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
     */
    private $voteTruckId;
    /**
     * the value of the vote, which will be either an up or down vote
     */
    private $voteValue;
    /**
     * constructor for this Vote
     *
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
     *
     *
     *
     */
}