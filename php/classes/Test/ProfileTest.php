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
     * valid username to use
     * @var string $VALID_USERNAME
     **/
    private $VALID_USERNAME = "MarikaJ";





    /**
     *
     **/
    public final function setUp() : void {
    parent::setUp();
    //
    $password = "strongpassword";
    --------------------------------------
    }
}































