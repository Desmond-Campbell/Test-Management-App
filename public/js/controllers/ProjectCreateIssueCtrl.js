app.controller('ProjectCreateIssueCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.issue = {};		
	$scope.project_id = $( '#project_id').val();
	$scope.test_id = $( '#test_id').val();
	$scope.activity_id = $( '#activity_id').val();
	$scope.step_id = $( '#step_id').val();
	$scope.batch_id = $( '#batch_id').val();

	$scope.save = function () {

		$id = $scope.project_id;

		l(1);
		$http.post( '/projects/' + $id + '/tests/' + $scope.test_id + '/batch/' + $scope.batch_id + '/activity/' + $scope.activity_id + '/step/' + $scope.step_id + '/create-issue', $scope.issue ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
				
					pageconfig = $("#pageconfig").val();

					if ( pageconfig != 'template-full' ) {

						_notifySuccess( 'Issue was saved successfully.' );

					} else {

						$scope.test = {};
						$scope.cancel( r.data.result );

					}

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to save issue.' );

			});

	};

}]);
