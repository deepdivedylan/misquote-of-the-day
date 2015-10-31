app.controller("MisquoteController", ["$scope", "$uibModal", "$window", "MisquoteService", "Pusher", function($scope, $uibModal, $window, MisquoteService, Pusher) {
	$scope.editedMisquote = {};
	$scope.newMisquote = {misquoteId: null, attribution: "", misquote: "", submitter: ""};
	$scope.isEditing = false;
	$scope.alerts = [];
	$scope.misquotes = [];

	$scope.setEditedMisquote = function(misquote) {
		$scope.editedMisquote = angular.copy(misquote);
		$scope.isEditing = true;
	};

	$scope.cancelEditing = function() {
		$scope.editedTweet = null;
		$scope.isEditing = false;
	};

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

	$scope.createMisquote = function(misquote, validated) {
		if(validated === true) {
			MisquoteService.create(misquote)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	$scope.updateMisquote = function(misquote, validated) {
		if(validated === true && $scope.isEditing === true) {
			MisquoteService.update(misquote.misquoteId, misquote)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	$scope.deleteMisquote = function(misquoteId) {
		var message = "Do you really want to delete this misquote?";

		var modalHtml = '<div class="modal-body">' + message + '</div><div class="modal-footer"><button class="btn btn-primary" ng-click="yes()">Yes</button><button class="btn btn-warning" ng-click="no()">No</button></div>';

		var modalInstance = $uibModal.open({
			template: modalHtml,
			controller: ModalInstanceCtrl
		});

		modalInstance.result.then(function () {
			MisquoteService.destroy(misquoteId)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				})
		});
	};

	Pusher.subscribe("misquote", "delete", function(misquote) {
		for(var i = 0; i < $scope.misquotes.length; i++) {
			if($scope.misquotes[i].misquoteId === misquote.misquoteId) {
				$scope.misquotes.splice(i, 1);
			}
		}
	});

	Pusher.subscribe("misquote", "new", function(misquote) {
		$scope.misquotes.push(misquote);
	});

	Pusher.subscribe("misquote", "update", function(misquote) {
		for(var i = 0; i < $scope.misquotes.length; i++) {
			if($scope.misquotes[i].misquoteId === misquote.misquoteId) {
				$scope.misquotes[i] = misquote;
			}
		}
	});

	$scope.$on("$destroy", function () {
		Pusher.unsubscribe("misquote");
	});

	if($scope.misquotes.length === 0) {
		$scope.misquotes = $scope.getMisquotes();
	}
}]);

var ModalInstanceCtrl = function($scope, $uibModalInstance) {
	$scope.yes = function() {
		$uibModalInstance.close();
	};

	$scope.no = function() {
		$uibModalInstance.dismiss('cancel');
	};
};