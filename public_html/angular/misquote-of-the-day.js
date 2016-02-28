var app = angular.module("MisquoteOfTheDay", ["ngMessages", "ngRoute", "doowb.angular-pusher", "ui.bootstrap"]);

app.config(function($routeProvider) {
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
});