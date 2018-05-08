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
     * id for this vote; this is the primary key
     * @var Uuid $truckId
     **/
    private $voteProfileId;
    /**
     * id of the truck that is being voted on
     */
    private $voteTruckId;
    /**
     * the value of the vote; either up or down vote
     */
    private $voteValue;
    /**
     *
     */


}