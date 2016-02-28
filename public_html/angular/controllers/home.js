app.controller("HomeController", ["$scope", "MisquoteService", function($scope, MisquoteService) {
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

	// load the array on first view
	if($scope.misquotes.length === 0) {
		$scope.misquotes = $scope.getMisquotes();
	}
}]);