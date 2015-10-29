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
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-pusher/0.0.14/angular-pusher.min.js"></script>
		<script type="text/javascript" src="angular/misquote-of-the-day.js"></script>
		<script type="text/javascript" src="angular/pusher-config.js"></script>
		<script type="text/javascript" src="angular/services/misquote.js"></script>
		<script type="text/javascript" src="angular/controllers/misquote.js"></script>
		<title>Misquote of the Day</title>
	</head>
	<body>
		<main class="container" ng-controller="MisquoteController">
			<h1>Misquotes</h1>
			<div class="row">
				<div class="col-md-4">
					<blockquote>
						Resistance is futile.
						<footer>The Borg</footer>
					</blockquote>
				</div>
				<div class="col-md-8">
					<table class="table table-hover table-responsive table-striped table-word-wrap">
						<tr><th>Misquote ID</th><th>Misquote</th><th>Attribution</th><th>Submitter</th><th>Actions</th></tr>
						<tr ng-repeat="misquote in misquotes">
							<td>{{ misquote.misquoteId }}</td>
							<td>{{ misquote.misquote }}</td>
							<td>{{ misquote.attribution }}</td>
							<td>{{ misquote.submitter }}</td>
							<td>
								<button class="btn btn-info" ng-click="setEditedMisquote(misquote);"><i class="fa fa-pencil"></i></button>
								<form class="inline" ng-submit="deleteMisquote(misquote.misquoteId);">
									<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
								</form>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<uib-alert ng-repeat="alert in alerts" type="{{ alert.type }}" close="alerts.length = 0;">{{ alert.msg }}</uib-alert>
		</main>
	</body>
</html>