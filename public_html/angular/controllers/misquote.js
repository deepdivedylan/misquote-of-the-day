app.controller("MisquoteController", ["$scope", "MisquoteService", function($scope, MisquoteService) {
	$scope.alerts = [];
	$scope.misquotes = [];

	$scope.getMisquotes = function() {
		MisquoteService.all()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.misquotes = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message}
				}
			});
	};

	if($scope.misquotes.length === 0) {
		$scope.misquotes = $scope.getMisquotes();
	}
}]);