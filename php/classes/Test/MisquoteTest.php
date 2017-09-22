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
	 * content of this Misquote for an update
	 * @var string $VALID_MISQUOTE2
	 **/
	protected $VALID_MISQUOTE2 = "Escape keys are good with green chile.";
	/**
	 * submitter of this Misquote
	 * @var string $VALID_SUBMITTER
	 **/
	protected $VALID_SUBMITTER = "Pra'etor Si'mon";

	/**
	 * test inserting a valid Misquotre and verify the actual mySQL matches
	 **/
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

	/**
	 * test inserting a Misquote, editing it, and then updating it
	 **/
	public function testUpdateValidMisquote() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("misquote");

		// create a Misquote and insert it into mySQL
		$misquoteId = generateUuidV4();
		$misquote = new Misquote($misquoteId, $this->VALID_ATTRIBUTION, $this->VALID_MISQUOTE, $this->VALID_SUBMITTER);
		$misquote->insert($this->getPDO());

		// edit the Misquote and update it in mySQL
		$misquote->setMisquote($this->VALID_MISQUOTE2);
		$misquote->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match expectations
		$pdoMisquote = Misquote::getMisquoteByMisquoteId($this->getPDO(), $misquoteId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("misquote"));
		$this->assertEquals($pdoMisquote->getMisquoteId(), $misquoteId);
		$this->assertEquals($pdoMisquote->getAttribution(), $this->VALID_ATTRIBUTION);
		$this->assertEquals($pdoMisquote->getMisquote(), $this->VALID_MISQUOTE2);
		$this->assertEquals($pdoMisquote->getSubmitter(), $this->VALID_SUBMITTER);
	}

	/**
	 * test creating a Misquote and then deleting it
	 **/
	public function testDeleteValidMisquote() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("misquote");

		// create a Misquote and insert it into mySQL
		$misquoteId = generateUuidV4();
		$misquote = new Misquote($misquoteId, $this->VALID_ATTRIBUTION, $this->VALID_MISQUOTE, $this->VALID_SUBMITTER);
		$misquote->insert($this->getPDO());

		// delete the Misquote from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("misquote"));
		$misquote->delete($this->getPDO());

		// grab the data from mySQL and enforce the Misquote does not exist
		$pdoMisquote = Misquote::getMisquoteByMisquoteId($this->getPDO(), $misquoteId);
		$this->assertNull($pdoMisquote);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("misquote"));
	}
}