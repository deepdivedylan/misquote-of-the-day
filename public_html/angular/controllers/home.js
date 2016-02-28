app.controller("HomeController", ["$location", "$scope", "MisquoteService", function($location, $scope, MisquoteService) {
	$scope.misquotes = [];

	/**
	 * fulfills the promise from retrieving the misquotes from misquote API
	 **/
	$scope.getMisquotes = function() {
		MisquoteService.all()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.misquotes = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};

	/**
	 * reroute the page to the specified misquote
	 *
	 * @param misquoteId id of the misquote to load
	 **/
	$scope.loadMisquote = function(misquoteId) {
		$location.path("misquote/" + misquoteId);
	};

	// load the array on first view
	if($scope.misquotes.length === 0) {
		$scope.misquotes = $scope.getMisquotes();
	}
}]);