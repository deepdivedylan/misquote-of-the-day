app.controller("MisquoteController", ["$scope", "$uibModal", "$window", "MisquoteService", "Pusher", function($scope, $uibModal, $window, MisquoteService, Pusher) {
	$scope.editedMisquote = {};
	$scope.newMisquote = {misquoteId: null, attribution: "", misquote: "", submitter: ""};
	$scope.isEditing = false;
	$scope.alerts = [];
	$scope.misquotes = [];

	/**
	 * sets the which misquote is being edited and activates the editing form
	 *
	 * @param misquote the misquote to load into the editing form
	 **/
	$scope.setEditedMisquote = function(misquote) {
		$scope.editedMisquote = angular.copy(misquote);
		$scope.isEditing = true;
	};

	/**
	 * cancels editing and clears out the misquote being edited
	 **/
	$scope.cancelEditing = function() {
		$scope.editedMisquote = {};
		$scope.isEditing = false;
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
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	/**
	 * updates a misquote and sends it to the misquote API
	 *
	 * @param misquote the misquote to send
	 * @param validated true if Angular validated the form, false if not
	 **/
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

	/**
	 * deletes a misquote and sends it to the misquote API, if the user confirms deletion
	 *
	 * @param misquoteId the misquote id to delete
	 **/
	$scope.deleteMisquote = function(misquoteId) {
		// create a modal instance to prompt the user if she/he is sure they want to delete the misquote
		var message = "Do you really want to delete this misquote?";

		var modalHtml = '<div class="modal-body">' + message + '</div><div class="modal-footer"><button class="btn btn-primary" ng-click="yes()">Yes</button><button class="btn btn-warning" ng-click="no()">No</button></div>';

		var modalInstance = $uibModal.open({
			template: modalHtml,
			controller: ModalInstanceCtrl
		});

		// if the user clicked "yes", delete the misquote
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

// embedded modal instance controller to create deletion prompt
var ModalInstanceCtrl = function($scope, $uibModalInstance) {
	$scope.yes = function() {
		$uibModalInstance.close();
	};

	$scope.no = function() {
		$uibModalInstance.dismiss('cancel');
	};
};