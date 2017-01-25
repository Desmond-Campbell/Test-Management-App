app.controller('CasesCtrl', ['$scope', '$http', function ( $scope, $http ) {

	$scope.project_id = $('#project_id').val();
	$scope.cases = {};

	// Load cases

	$scope.getTestCases = function () {

		$http.get( '/projects/' + $scope.project_id + '/cases?format=json' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors == 'undefined' ) {

					$scope.cases = r.data.cases;

				}
			
			},

			function () {

			});

	};

	$scope.getTestCases();

	$scope.copy = function ( id ) {

		$http.post( '/projects/' + $scope.project_id + '/cases/' + id + '/copy' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors == 'undefined' ) {

					_notify( 'Test case copied successfully.' );
					$scope.getTestCases();

				} else {

					_alert( r.data.errors, 1 );

				}
			
			},

			function () {

				_alert( 'Failed to copy test case.' );

			});

	};

	$scope.delete = function ( id ) {

		$http.delete( '/projects/' + $scope.project_id + '/cases/' + id + '/delete' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors == 'undefined' ) {

					_notify( 'Test case deleted successfully.' );
					$scope.getTestCases();

				} else {

					_alert( r.data.errors, 1 );

				}
			
			},

			function () {

				_alert( 'Failed to delete test case.' );

			});

	};

}]);