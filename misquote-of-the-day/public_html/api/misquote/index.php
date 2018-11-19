<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\MisquoteOfTheDay\Misquote;
use Pusher\Pusher;

// start the session and create a XSRF token
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// create the Pusher connection
	$config = readConfig("/etc/apache2/capstone-mysql/misquote.ini");
	$pusherConfig = json_decode($config["pusher"]);
	$pusher = new Pusher($pusherConfig->key, $pusherConfig->secret, $pusherConfig->id, ["encrypted" => true]);

	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize the id
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/misquote.ini");

	// handle all RESTful calls to Misquote
	// get some or all Misquotes
	if($method === "GET") {
		// set an XSRF cookie on GET requests
		setXsrfCookie("/");
		if(empty($id) === false) {
			$reply->data = Misquote::getMisquoteByMisquoteId($pdo, $id);
		} else {
			$reply->data = Misquote::getAllMisquotes($pdo)->toArray();
		}
		// put to an existing Misquote
	} else if($method === "PUT") {
		// convert PUTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$misquote = new Misquote($id, $requestObject->attribution, $requestObject->misquote, $requestObject->submitter);
		$misquote->update($pdo);
		$pusher->trigger("misquote", "update", $misquote);
		$reply->message = "Misquote updated OK";
		// post to a new Misquote
	} else if($method === "POST") {
		// convert POSTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$misquote = new Misquote(generateUuidV4(), $requestObject->attribution, $requestObject->misquote, $requestObject->submitter);
		$misquote->insert($pdo);
		$pusher->trigger("misquote", "new", $misquote);
		$reply->message = "Misquote created OK";
		// delete an existing Misquote
	} else if($method === "DELETE") {
		verifyXsrf();
		$misquote = Misquote::getMisquoteByMisquoteId($pdo, $id);
		if($misquote === null) {
			throw(new RuntimeException("Misquote does not exist", 404));
		}
		$misquote->delete($pdo);
		$deletedObject = new stdClass();
		$deletedObject->misquoteId = $id;
		$pusher->trigger("misquote", "delete", $deletedObject);
		$reply->message = "Misquote deleted OK";
	}
// create an exception to pass back to the RESTful caller
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
echo json_encode($reply);
