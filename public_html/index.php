<?php
/**
* Angular version
**/
$ANGULAR_VERSION = "1.5.0";
?>
<!DOCTYPE html>
<html ng-app="MisquoteOfTheDay">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
		<link type="text/css" href="css/misquote-of-the-day.css" rel="stylesheet" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular-messages.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular-route.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.2.1/ui-bootstrap-tpls.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-pusher/0.0.14/angular-pusher.min.js"></script>
		<script type="text/javascript" src="angular/misquote-of-the-day.js"></script>
		<script type="text/javascript" src="angular/pusher-config.js"></script>
		<script type="text/javascript" src="angular/services/misquote.js"></script>
		<script type="text/javascript" src="angular/controllers/home.js"></script>
		<script type="text/javascript" src="angular/controllers/misquote.js"></script>
		<title>Misquote of the Day</title>
	</head>
	<body>
		<main class="container">
			<h1>Misquotes</h1>
			<div class="row">
				<div class="col-md-4">
					<img class="img-responsive" src="images/miss-quote.png" alt="">
				</div>
				<div class="col-md-8">
					<blockquote>
						That is the problem with memes. If you have the right font and the right photo, any quote can seem real. And I'll tell you how I know that. Because for years now you may have seen multiple photos of me comparing gun control to airport security. It's an interesting thought. Here's the thing: I never said that! Even though, I've now seen it so many times now I'm starting to genuinely wonder if I ever did.
						<footer>
							John Oliver on <cite>Last Week Tonight</cite>
						</footer>
					</blockquote>
					<p>
						I now present you with the opportunity to make your own misquotes. Want to claim you solved <var>P</var> = <var>NP</var>? You've come to the right place. Want to prove Sir Isaac Newton was hit on the head with an apple while making apple pie? Done!
					</p>
					<h3>Enjoy!</h3>
				</div>
			</div>
			<hr />
			<div class="row" ng-view></div>
		</main>
	</body>
</html>
