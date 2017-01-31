app.controller('ProjectSuitesEditCaseCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();
	$scope.case_id = $( '#case_id').val();
	$scope.suite_id = $( '#suite_id').val();
	$scope.case = [];

	// Load case

	$scope.getCase = function () {

		$id = $scope.project_id;

		$http.get( '/projects/' + $id + '/suites/' + $scope.suite_id + '/get-case/' + $scope.case_id ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.case = r.data.case;

				}
			
			},

			function () {

				_alert( 'Failed to load test case.' );

			});

	};

	$scope.getCase();

	$scope.save = function () {

		$id = $scope.project_id;

		l(1);
		$http.post( '/projects/' + $id + '/suites/' + $scope.suite_id + '/update-case/' + $scope.case_id, $scope.case ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
				
					pageconfig = $("#pageconfig").val();

					if ( pageconfig != 'template-full' ) {

						_notifySuccess( 'Case was updated successfully.' );

					} else {

						$scope.case = {};
						$scope.cancel( r.data.result );

					}

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to save test case.' );

			});

	};

	$scope.cancel = function ( result ) {
		parent.passResult( result );
	};

	$scope.steps = [];
	$scope.steps.push( { name : 'Step 1' } );
	$scope.steps.push( { name : 'Step 2' } );
	$scope.steps.push( { name : 'Step 3' } );

	$scope.newstep = "";
	$scope.editindex = -1;

	$scope.addStep = function () {
		$scope.steps.push( { name : $scope.newstep } );
		$scope.newstep = '';
	};

	$scope.editStep = function ( i ) {
		$scope.editindex = i;
	};

	$scope.checkIndex = function ( i ) {
		return $scope.editindex == i;
	}

	$scope.cancelEditStep = function () {
		console.log($scope.editindex, 'before');
		$scope.editindex = 2;
		console.log($scope.editindex, 'after');
	};

}]);