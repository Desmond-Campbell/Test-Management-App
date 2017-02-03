app.controller('ProjectSuitesEditScenarioCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();
	$scope.scenario_id = $( '#scenario_id').val();
	$scope.suite_id = $( '#suite_id').val();
	$scope.scenario = {};

	// Load scenario

	$scope.getScenario = function () {

		$id = $scope.project_id;

		$http.get( '/projects/' + $id + '/suites/' + $scope.suite_id + '/get-scenario/' + $scope.scenario_id ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.scenario = r.data.scenario;

				}
			
			},

			function () {

				_alert( 'Failed to load test scenario.' );

			});

	};

	$scope.getScenario();

	$scope.save = function () {

		$id = $scope.project_id;

		l(1);
		$http.post( '/projects/' + $id + '/suites/' + $scope.suite_id + '/update-scenario/' + $scope.scenario_id, $scope.scenario ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
				
					pageconfig = $("#pageconfig").val();

					if ( pageconfig != 'template-full' ) {

						_notifySuccess( 'Scenario was updated successfully.' );

					} else {

						$scope.scenario = {};
						$scope.cancel( r.data.result );

					}

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to save test scenario.' );

			});

	};

	$scope.cancel = function ( result ) {
		parent.passResult( result );
	};

	$scope.files = [];

	$scope.getScenarioFiles = function () {

		$http.get( '/projects/' + $id + '/suites/' + $scope.suite_id + '/get-scenario-files/' + $scope.scenario_id, $scope.scenario ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
				
					$scope.files = r.data.files;

				}
			
			},

			function () {

				_alert( 'Failed to load test files.' );

			});

	};

	//$scope.getScenarioFiles();

	$scope.addScenarioFile = function () {

		

	};

	/*$scope.saveSteps = function () {

		$http.post( '/projects/' + $id + '/suites/' + $scope.suite_id + '/save-steps/' + $scope.case_id, { steps: $scope.steps } ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
				
				}
			
			},

			function () {

				_alert( 'Failed to load test steps.' );

			});

	};*/


}]);