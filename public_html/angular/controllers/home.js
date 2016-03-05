app.controller("HomeController", ["$location", "$scope", "MisquoteService", "Pusher", function($location, $scope, MisquoteService, Pusher) {
	$scope.collapseAddForm = true;
	$scope.misquotes = [];
	$scope.newMisquote = {misquoteId: null, attribution: "", misquote: "", submitter: ""};
	$scope.alerts = [];

	/**
	 * creates a misquote and sends it to the misquote API
	 *
	 * @param misquote the misquote to send
	 * @param validated true if Angular validated the form, false if not
	 **/
	$scope.createMisquote = function(misquote, validated) {
		if(validated === true) {
			MisquoteService.create(misquote)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						$scope.newMisquote = {misquoteId: null, attribution: "", misquote: "", submitter: ""};
						$scope.addMisquoteForm.$setPristine();
						$scope.addMisquoteForm.$setUntouched();
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

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

	// subscribe to the delete channel; this will delete from the misquotes array on demand
	Pusher.subscribe("misquote", "delete", function(misquote) {
		for(var i = 0; i < $scope.misquotes.length; i++) {
			if($scope.misquotes[i].misquoteId === misquote.misquoteId) {
				$scope.misquotes.splice(i, 1);
				break;
			}
		}
	});

	// subscribe to the new channel; this will add to the misquotes array on demand
	Pusher.subscribe("misquote", "new", function(misquote) {
		$scope.misquotes.push(misquote);
	});

	// subscript to the update channel; this will update the misquotes array on demand
	Pusher.subscribe("misquote", "update", function(misquote) {
		for(var i = 0; i < $scope.misquotes.length; i++) {
			if($scope.misquotes[i].misquoteId === misquote.misquoteId) {
				$scope.misquotes[i] = misquote;
				break;
			}
		}
	});

	// when the window is closed/reloaded, gracefully close the channel
	$scope.$on("$destroy", function () {
		Pusher.unsubscribe("misquote");
	});

	// load the array on first view
	if($scope.misquotes.length === 0) {
		$scope.misquotes = $scope.getMisquotes();
	}
}]);