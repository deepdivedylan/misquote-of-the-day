var app = angular.module("MisquoteOfTheDay", ["ngMessages", "ngRoute", "doowb.angular-pusher", "ui.bootstrap"]);

app.config(function($routeProvider, $locationProvider) {
	$routeProvider
		.when("/", {
			controller: "HomeController",
			templateUrl: "angular/templates/home.php"
		})
		.when("/misquote/:id", {
			controller: "MisquoteController",
			templateUrl: "angular/templates/misquote.php"
		})
		.otherwise({
			redirectTo: "/"
		});

	// remove the # using the HTML 5 History API
	$locationProvider.html5Mode(true);
});