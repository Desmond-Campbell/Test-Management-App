app.controller('ProjectSuitesAddCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();
	$scope.suites = [];
	$scope.suite = {};

	// Load suites

	$scope.getSuites = function () {

		$id = $scope.project_id;

		$http.get( '/projects/' + $id + '/suites?format=json&request-type=namesonly' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.suites = r.data.suites;

				}
			
			},

			function () {

			});

	};

	$scope.save = function () {

		$id = $scope.project_id;

		l(1);
		$http.post( '/projects/' + $id + '/suites/create', $scope.suite ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.suite = {};

					if ( typeof r.data.result_id != 'undefined' ) {

						location.assign( '/projects/' + $id + '/suites?suite_id=' + r.data.result_id );

					} else {

						location.assign( '/projects/' + $id + '/suites' );

					}

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to load test suites.' );

			});

	};

}]);