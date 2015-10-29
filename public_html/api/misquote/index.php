<?php
require_once(dirname(dirname(__DIR__)) . "/classes/misquote.php");
require_once(dirname(dirname(__DIR__)) . "/lib/xsrf.php");
require_once("/etc/apache2/data-design/encrypted-config.php");

// start the session and create a XSRF token
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize the id
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	// grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/data-design/misquote.ini");

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
		$reply->message = "Misquote updated OK";
		// post to a new Misquote
	} else if($method === "POST") {
		// convert POSTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$misquote = new Misquote(null, $requestObject->attribution, $requestObject->misquote, $requestObject->submitter);
		$misquote->insert($pdo);
		$reply->message = "Misquote created OK";
		// delete an existing Misquote
	} else if($method === "DELETE") {
		verifyXsrf();
		$misquote = Misquote::getMisquoteByMisquoteId($pdo, $id);
		if($misquote === null) {
			throw(new RuntimeException("Misquote does not exist", 404));
		}
		$misquote->delete($pdo);
		$reply->message = "Misquote deleted OK";
	}
// create an exception to pass back to the RESTful caller
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);