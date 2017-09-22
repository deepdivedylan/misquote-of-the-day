<?php
namespace Edu\Cnm\MisquoteOfTheDay\Test;

use Edu\Cnm\MisquoteOfTheDay\Misquote;

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

class MisquoteTest extends MisquoteOfTheDayTest {
	/**
	 * attribution of this Misquote
	 * @var string $VALID_ATTRIBUTION
	 **/
	protected $VALID_ATTRIBUTION = "Senator Arlo";
	/**
	 * content of this Misquote
	 * @var string $VALID_MISQUOTE
	 **/
	protected $VALID_MISQUOTE = "The best pastries are escape key stuffed pastries.";
	/**
	 * submitter of this Misquote
	 * @var string $VALID_SUBMITTER
	 **/
	protected $VALID_SUBMITTER = "Pra'etor Si'mon";

	public function testInsertValidMisquote() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("misquote");

		// create a Misquote and insert it into mySQL
		$misquoteId = generateUuidV4();
		$misquote = new Misquote($misquoteId, $this->VALID_ATTRIBUTION, $this->VALID_MISQUOTE, $this->VALID_SUBMITTER);
		$misquote->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match expectations
		$pdoMisquote = Misquote::getMisquoteByMisquoteId($this->getPDO(), $misquoteId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("misquote"));
		$this->assertEquals($pdoMisquote->getMisquoteId(), $misquoteId);
		$this->assertEquals($pdoMisquote->getAttribution(), $this->VALID_ATTRIBUTION);
		$this->assertEquals($pdoMisquote->getMisquote(), $this->VALID_MISQUOTE);
		$this->assertEquals($pdoMisquote->getSubmitter(), $this->VALID_SUBMITTER);
	}

}