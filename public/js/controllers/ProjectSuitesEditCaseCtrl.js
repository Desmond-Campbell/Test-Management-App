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
	$scope.editindex = null;
	$scope.editmode = false;

	$scope.addStep = function () {
		$scope.steps.push( { name : $scope.newstep } );
		$scope.newstep = '';
	};

	$scope.stash = {};

	$scope.editStep = function ( i ) {
		$scope.editindex = i;
			original = angular.copy( $scope.steps[i] );
		$scope.stash = original;
		$scope.editmode = true;
	};

	$scope.resetStep = function ( i ) {
		stash = angular.copy( $scope.stash );
		$scope.steps[i] = stash;
		$scope.cancelEditStep();
	};

	$scope.checkIndex = function ( i ) {
		return $scope.editindex == i && $scope.editmode;
	}

	$scope.cancelEditStep = function () {
		$scope.editmode = false;
	};

	$scope.moveStep = function ( i, d ) {

		steps = $scope.steps;
		old = steps[i];
    j = d ? i + 1 : i -1;

    if ( j < 0 ) j = 0;
    if ( j >= steps.length ) j = steps.length - 1;

    steps[i] = steps[j]; steps[j] = old;
    $scope.editStep(j);

		$scope.steps = steps;

	};

	$scope.moveUpStep = function ( i ) {
		return $scope.moveStep( i, 0 );
	};

	$scope.moveDownStep = function ( i ) {
		return $scope.moveStep( i, 1 );
	};

	$scope.copyStep = function ( i ) {

		var step = angular.copy( $scope.steps[i] );
		step.name += ' -copy';
		$scope.steps.push(step);
		$scope.editStep($scope.steps.length-1);

	};


}]);