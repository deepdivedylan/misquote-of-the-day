<?php
/**
* Angular version
**/
$ANGULAR_VERSION = "1.4.7";
?>
<!DOCTYPE html>
<html ng-app="MisquoteOfTheDay">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
		<link type="text/css" href="css/misquote-of-the-day.css" rel="stylesheet" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular-messages.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.14.3/ui-bootstrap-tpls.min.js"></script>
		<script type="text/javascript" src="angular/misquote-of-the-day.js"></script>
		<script type="text/javascript" src="angular/services/misquote.js"></script>
		<title>Misquote of the Day</title>
	</head>
	<body>
	</body>
</html>