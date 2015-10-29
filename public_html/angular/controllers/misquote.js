app.controller("MisquoteController", ["$scope", "$uibModal", "MisquoteService", function($scope, $uibModal, MisquoteService) {
	$scope.alerts = [];
	$scope.misquotes = [];

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
						$scope.getMisquotes();
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				})
		});
	};

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