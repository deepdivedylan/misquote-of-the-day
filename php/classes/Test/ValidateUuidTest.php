<?php
namespace Edu\Cnm\MisquoteOfTheDay\Test;

use Edu\Cnm\MisquoteOfTheDay\ValidateUuid;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");


/**
 * Minimal UUID Class
 *
 * This class is a minimal class that uses the ValidateUuid trait in order to test the accessor and mutator methods
 **/
class UuidTestObject {
	use ValidateUuid;

	/**
	 * minimal uuid state variable
	 * @var Uuid $uuid
	 **/
	private $uuid;

	/**
	 * accessor method for uuid
	 *
	 * @return Uuid current value of uuid
	 **/
	public function getUuid() : Uuid {
		return($this->uuid);
	}

	/**
	 * mutator method for uuid
	 *
	 * @param $newUuid Uuid new value of uuid
	 **/
	public function setUuid($newUuid) {
		try {
			$uuid = self::validateUuid($newUuid);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// store the uuid
		$this->uuid = $uuid;
	}
}

/**
 * Full PHPUnit test for ValidateUuid trait
 *
 * This test class does not communicate with the database. Rather, it verifies that all the possible uuid inputs and
 * enforces that valid inputs will be allowed.
 **/
class ValidateUuidTest extends TestCase {

	/**
	 * valid uuid in raw bytes from mySQL
	 * @var string $VALID_BYTES
	 **/
	protected $VALID_BYTES = null;
	/**
	 * test object using the ValidateUuid trait
	 * @var UuidTestObject $VALID_OBJECT
	 **/
	protected $VALID_OBJECT = null;
	/**
	 * valid uuid in human readable string
	 * @var string $VALID_STRING
	 **/
	protected $VALID_STRING = "a300f5c8-ac56-430d-a683-343298ea88d2";
	/**
	 * valid uuid already in a Uuid object
	 * @var Uuid $VALID_UUID
	 **/
	protected $VALID_UUID = null;

	/**
	 * create dependent objects before running each test
	 **/
	public function setUp() {
		// seed bytes with an actual uuid
		$this->VALID_BYTES = chr(118) . chr(9) . chr(185) . chr(49) . chr(221) . chr(132) . chr(79) . chr(33) . chr(165) . chr(15) . chr(133) . chr(169) . chr(172) . chr(81) . chr(251) . chr(146);
		$this->VALID_OBJECT = new UuidTestObject();
		$this->VALID_UUID = generateUuidV4();
	}

	/**
	 * test creating a uuid from raw bytes from mySQL
	 **/
	public function testInsertValidBytes() {
		$uuid = Uuid::fromBytes($this->VALID_BYTES);
		$this->assertInstanceOf("Ramsey\\Uuid\\Uuid", $uuid);
		$this->VALID_OBJECT->setUuid($this->VALID_BYTES);
		$this->assertInstanceOf("Ramsey\\Uuid\\Uuid", $this->VALID_OBJECT->getUuid());
	}

	/**
	 * test creating a uuid from another Uuid object
	 **/
	public function testInsertValidObject() {
		$this->assertInstanceOf("Ramsey\\Uuid\\Uuid", $this->VALID_UUID);
		$this->VALID_OBJECT->setUuid($this->VALID_UUID);
		$this->assertInstanceOf("Ramsey\\Uuid\\Uuid", $this->VALID_OBJECT->getUuid());
	}

	/**
	 * test creating a uuid from a human readable string
	 **/
	public function testInsertValidString() {
		$uuid = Uuid::fromString($this->VALID_STRING);
		$this->assertTrue(Uuid::isValid($this->VALID_STRING));
		$this->assertInstanceOf("Ramsey\\Uuid\\Uuid", $uuid);
		$this->VALID_OBJECT->setUuid($this->VALID_STRING);
		$this->assertInstanceOf("Ramsey\\Uuid\\Uuid", $this->VALID_OBJECT->getUuid());
	}
}