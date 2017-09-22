<?php

namespace Edu\Cnm\MisquoteOfTheDay;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Misquote mySQL Enabled Class
 *
 * This is a class that stores, updates, and deletes a misquote, which includes who is being misquoted and who to blame.
 *
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class Misquote implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * id for this Misquote; this is the primary key
	 * @var Uuid $misquoteId
	 **/
	private $misquoteId;
	/**
	 * attribution of who allegedly said the Misquote
	 * @var string $attribution
	 **/
	private $attribution;
	/**
	 * actual text of the Misquote
	 * @var string $misquote
	 **/
	private $misquote;
	/**
	 * who submitted the Misquote
	 * @var string $submitter
	 **/
	private $submitter;

	/**
	 * constructor for this Misquote
	 *
	 * @param string|Uuid $newMisquoteId id of this Misquote or null if new Misquote
	 * @param string $newAttribution string containing attribution for this Misquote
	 * @param string $newMisquote string containing misquote
	 * @param string $newSubmitter string containing who submitted this Misquote
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \Exception if some other exception is thrown
	 */
	public function __construct($newMisquoteId, string $newAttribution, string $newMisquote, string $newSubmitter) {
		try {
			$this->setMisquoteId($newMisquoteId);
			$this->setAttribution($newAttribution);
			$this->setMisquote($newMisquote);
			$this->setSubmitter($newSubmitter);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for misquoteId
	 *
	 * @return Uuid value of misquoteId
	 **/
	public function getMisquoteId(): Uuid {
		return ($this->misquoteId);
	}

	/**
	 * mutator method for misquoteId
	 *
	 * @param string|Uuid $newMisquoteId new value of misquote id
	 * @throws \InvalidArgumentException if $newMisquoteId is not a valid uuid
	 * @throws \RangeException if $newMisquoteId is not a valid uuid v4
	 **/
	public function setMisquoteId($newMisquoteId): void {
		try {
			$uuid = self::validateUuid($newMisquoteId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// store the misquote id
		$this->misquoteId = $uuid;
	}

	/**
	 * accessor method for attribution
	 *
	 * @return string value of attribution
	 **/
	public function getAttribution(): string {
		return ($this->attribution);
	}

	/**
	 * mutator method for attribution
	 *
	 * @param string $newAttribution new value of attribution
	 * @throws \InvalidArgumentException if $newAttribution is not a string or insecure
	 * @throws \RangeException if $newAttribution is > 64 characters
	 **/
	public function setAttribution(string $newAttribution): void {
		// verify the attribution is secure
		$newAttribution = trim($newAttribution);
		$newAttribution = filter_var($newAttribution, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAttribution) === true) {
			throw(new \InvalidArgumentException("attribution is empty or insecure"));
		}

		// verify the attribution will fit in the database
		if(strlen($newAttribution) > 64) {
			throw(new \RangeException("attribution too large"));
		}

		// store the attribution
		$this->attribution = $newAttribution;
	}

	/**
	 * accessor method for misquote
	 *
	 * @return string value of misquote
	 **/
	public function getMisquote(): string {
		return ($this->misquote);
	}

	/**
	 * mutator method for misquote
	 *
	 * @param string $newMisquote new value of misquote
	 * @throws \InvalidArgumentException if $newMisquote is not a string or insecure
	 * @throws \RangeException if $newMisquote is > 255 characters
	 **/
	public function setMisquote(string $newMisquote): void {
		// verify the misquote is secure
		$newMisquote = trim($newMisquote);
		$newMisquote = filter_var($newMisquote, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newMisquote) === true) {
			throw(new \InvalidArgumentException("misquote is empty or insecure"));
		}

		// verify the misquote will fit in the database
		if(strlen($newMisquote) > 255) {
			throw(new \RangeException("misquote too large"));
		}

		// store the misquote
		$this->misquote = $newMisquote;
	}

	/**
	 * accessor method for submitter
	 *
	 * @return string value of submitter
	 **/
	public function getSubmitter(): string {
		return ($this->submitter);
	}

	/**
	 * mutator method for submitter
	 *
	 * @param string $newSubmitter new value of submitter
	 * @throws \InvalidArgumentException if $newSubmitter is not a string or insecure
	 * @throws \RangeException if $newSubmitter is > 64 characters
	 **/
	public function setSubmitter(string $newSubmitter): void {
		// verify the submitter is secure
		$newSubmitter = trim($newSubmitter);
		$newSubmitter = filter_var($newSubmitter, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newSubmitter) === true) {
			throw(new \InvalidArgumentException("submitter is empty or insecure"));
		}

		// verify the submitter will fit in the database
		if(strlen($newSubmitter) > 64) {
			throw(new \RangeException("submitter too large"));
		}

		// store the submitter
		$this->submitter = $newSubmitter;
	}

	/**
	 * inserts this Misquote into mySQL
	 *
	 * @param \PDO $pdo \PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO misquote(misquoteId, attribution, misquote, submitter) VALUES(:misquoteId, :attribution, :misquote, :submitter)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$misquoteId = $this->misquoteId->getBytes();
		$parameters = ["misquoteId" => $misquoteId, "attribution" => $this->attribution, "misquote" => $this->misquote, "submitter" => $this->submitter];
		$statement->execute($parameters);

		// update the null misquoteId with what mySQL just gave us
		$this->misquoteId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this Misquote from mySQL
	 *
	 * @param \PDO $pdo \PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM misquote WHERE misquoteId = :misquoteId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$misquoteId = $this->misquoteId->getBytes();
		$parameters = ["misquoteId" => $misquoteId];
		$statement->execute($parameters);
	}

	/**
	 * updates this Misquote in mySQL
	 *
	 * @param \PDO $pdo \PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function update(\PDO $pdo): void {
		// create query template
		$query = "UPDATE misquote SET attribution = :attribution, misquote = :misquote, submitter = :submitter WHERE misquoteId = :misquoteId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$misquoteId = $this->misquoteId->getBytes();
		$parameters = ["attribution" => $this->attribution, "misquote" => $this->misquote, "submitter" => $this->submitter, "misquoteId" => $misquoteId];
		$statement->execute($parameters);
	}

	/**
	 * gets the Misquote by misquote id
	 *
	 * @param \PDO $pdo \PDO connection object
	 * @param string $misquoteId misquote id to search for
	 * @return Misquote|null Misquote found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public static function getMisquoteByMisquoteId(\PDO $pdo, string $misquoteId): ?Misquote {
		// sanitize the misquote id before searching
		try {
			$misquoteId = self::validateUuid($misquoteId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT misquoteId, attribution, misquote, submitter FROM misquote WHERE misquoteId = :misquoteId";
		$statement = $pdo->prepare($query);

		// bind the misquote id to the place holder in the template
		$misquoteId = $misquoteId->getBytes();
		$parameters = ["misquoteId" => $misquoteId];
		$statement->execute($parameters);

		// grab the misquote from mySQL
		try {
			$misquote = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$misquote = new Misquote($row["misquoteId"], $row["attribution"], $row["misquote"], $row["submitter"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($misquote);
	}

	/**
	 * gets Misquotes by submitter
	 *
	 * @param \PDO $pdo \PDO connection object
	 * @param string $submitter submitter to search by
	 * @return \SplFixedArray all Misquotes found for this submitter
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public static function getMisquoteBySubmitter(\PDO $pdo, string $submitter): \SplFixedArray {
		// sanitize the submitter before searching
		$submitter = trim($submitter);
		$submitter = filter_var($submitter, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($submitter) === true) {
			throw(new \PDOException("submitter is invalid"));
		}

		// escape any mySQL wild cards
		$submitter = str_replace("_", "\\_", str_replace("%", "\\%", $submitter));

		// create query template
		$query = "SELECT misquoteId, attribution, misquote, submitter FROM misquote WHERE submitter LIKE :submitter";
		$statement = $pdo->prepare($query);

		// bind the submitter to the place holder in the template
		$submitter = "%$submitter%";
		$parameters = ["submitter" => $submitter];
		$statement->execute($parameters);

		// build an array of misquotes
		$misquotes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$misquote = new Misquote($row["misquoteId"], $row["attribution"], $row["misquote"], $row["submitter"]);
				$misquotes[$misquotes->key()] = $misquote;
				$misquotes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($misquotes);
	}

	/**
	 * gets all Misquotes
	 *
	 * @param \PDO $pdo \PDO connection object
	 * @return \SplFixedArray all Misquotes found for this submitter
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public static function getAllMisquotes(\PDO $pdo): \SplFixedArray {
		// create query template and execute the statement
		$query = "SELECT misquoteId, attribution, misquote, submitter FROM misquote";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of misquotes
		$misquotes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$misquote = new Misquote($row["misquoteId"], $row["attribution"], $row["misquote"], $row["submitter"]);
				$misquotes[$misquotes->key()] = $misquote;
				$misquotes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($misquotes);
	}

	/**
	 * specifies which fields to include in a JSON serialization
	 *
	 * @return array array containing all fields in this Misquote
	 **/
	function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["misquoteId"] = $this->misquoteId->toString();
		return($fields);
	}
}