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

	$scope.deleteCase = function () {

		if ( !getconfirm() ) return;
	
		$id = $scope.project_id;
  	$caseurl = '/projects/' + $id + '/suites/' + $scope.suite_id + '/scenario/' + $scope.case.scenario_id + '/delete-case/' + $scope.case_id;

		l(1);
		$http.delete( $caseurl ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					pageconfig = $("#pageconfig").val();
					
					if ( pageconfig != 1 ) {

						location.assign( '/projects/' + $id + '/suites?suite_id=' + $scope.suite_id + '&scenario_id=' + $scope.case.scenario_id );

					} else {

						$scope.case = {};
						$scope.cancel( null );

					}

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to delete test case.' );

			});

	};

	$scope.cancel = function ( result ) {
		parent.passResult( result );
	};

	$scope.steps = [];

	$scope.getSteps = function () {

		$http.get( '/projects/' + $id + '/suites/' + $scope.suite_id + '/get-steps/' + $scope.case_id, $scope.case ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
				
					$scope.steps = r.data.steps;

				}
			
			},

			function () {

				_alert( 'Failed to load test steps.' );

			});

	};

	$scope.getSteps();

	$scope.addStep = function () {

		if ( $scope.newstep != '' ) {
			$scope.steps.push( { name : $scope.newstep } );
			$scope.newstep = '';
			$scope.saveSteps();
		}

	};

	$scope.stash = {};

	$scope.editStep = function ( i ) {
		$scope.editindex = i;
			original = angular.copy( $scope.steps[i] );
		$scope.stash = original;
		$scope.editmode = true;
		editor = $('.step-editor:eq(' + i + ')');
		$timeout( editor.focus(), 500 );
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
		$scope.editindex = -1;
		$scope.saveSteps();
	};

	$scope.cancelAddStep = function () {
		$scope.newstep = '';
	};

	$scope.deleteStep = function ( i ) {
		if ( !getconfirm() ) return;
		$scope.steps.splice( i, 1 );
		$scope.cancelEditStep();
		$scope.saveSteps();
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
		$scope.saveSteps();

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
		step.id = null;
		$scope.steps.push(step);
		$scope.editStep($scope.steps.length-1);
		console.log('dupl', $scope.steps);
		$scope.saveSteps();

	};

	$scope.getStepClass = function ( i ) {

		$class = "no-push-down no-outlines test-step-item";

		if ( $scope.checkIndex( i ) ) { $class += " active-step"; }

		return $class;


	}

	$scope.saveSteps = function () {

		$http.post( '/projects/' + $id + '/suites/' + $scope.suite_id + '/save-steps/' + $scope.case_id, { steps: $scope.steps } ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {

					$scope.steps = r.data.steps;
				
				}
			
			},

			function () {

				_alert( 'Failed to load test steps.' );

			});

	};


}]);