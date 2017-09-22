<?php
namespace Edu\Cnm\MisquoteOfTheDay\Test;

use Edu\Cnm\MisquoteOfTheDay\ValidateUuid;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");


class UuidTestObject {
	use ValidateUuid;

	private $uuid;

	/**
	 * @return UuidInterface
	 */
	public function getUuid() : UuidInterface {
		return($this->uuid);
	}

	/**
	 * @param $newUuid
	 **/
	public function setUuid($newUuid) {
		try {
			$uuid = self::validateUuid($newUuid);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// store the misquote id
		$this->uuid = $uuid;
	}
}

class ValidateUuidTest extends TestCase {

	/**
	 * @var string $VALID_BYTES
	 **/
	protected $VALID_BYTES = null;


	/**
	 * @var UuidTestObject
	 **/
	protected $VALID_OBJECT = null;

	/**
	 * @var string $VALID_STRING
	 **/
	protected $VALID_STRING = "a300f5c8-ac56-430d-a683-343298ea88d2";

	/**
	 * @var UuidInterface $VALID_UUID
	 **/
	protected $VALID_UUID = null;

	public function setUp() {
		// seed bytes with an actual uuid
		$this->VALID_BYTES = chr(118) . chr(9) . chr(185) . chr(49) . chr(221) . chr(132) . chr(79) . chr(33) . chr(165) . chr(15) . chr(133) . chr(169) . chr(172) . chr(81) . chr(251) . chr(146);
		$this->VALID_OBJECT = new UuidTestObject();
		$this->VALID_UUID = generateUuidV4();
	}

	public function testInsertValidBytes() {
		$uuid = Uuid::fromBytes($this->VALID_BYTES);
		$this->assertInstanceOf("Ramsey\\Uuid\\Uuid", $uuid);
	}

	public function testInsertValidObject() {
		$this->assertInstanceOf("Ramsey\\Uuid\\Uuid", $this->VALID_UUID);
	}

	public function testInsertValidString() {
		$uuid = Uuid::fromString($this->VALID_STRING);
		$this->assertTrue(Uuid::isValid($this->VALID_STRING));
		$this->assertInstanceOf("Ramsey\\Uuid\\Uuid", $uuid);
	}
}