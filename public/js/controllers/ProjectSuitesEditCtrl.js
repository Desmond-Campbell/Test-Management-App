app.controller('ProjectSuitesEditCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();
	$scope.suite_id = $( '#suite_id').val();
	$scope.suite = {};

	// Load suite

	$scope.getSuite = function () {

		$id = $scope.project_id;

		$http.get( '/projects/' + $id + '/suites/' + $scope.suite_id + '/get' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.suite = r.data.suite;

				}
			
			},

			function () {

			});

	};

	$scope.getSuite();

	$scope.saveOnly = function () { $scope.save( 0 ); };

	$scope.saveAndClose = function () { $scope.save( 1 ); };

	$scope.save = function ( close ) {

		$id = $scope.project_id;

		l(1);
		$http.post( '/projects/' + $id + '/suites/' + $scope.suite_id + '/update', $scope.suite ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					_notifySuccess( 'Test suite updated successfully' );

					if ( close ) parent.passResult( null );

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to load test suite.' );

			});

	};

	$scope.deleteSuite = function () {

		$id = $scope.project_id;

		l(1);
		$http.delete( '/projects/' + $id + '/suites/' + $scope.suite_id + '/delete' ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					to( '/projects/' + $id + '/suites' );

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to delete test suite.' );

			});

	};

}]);