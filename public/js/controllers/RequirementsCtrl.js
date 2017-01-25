app.controller('RequirementsCtrl', ['$scope', '$http', function ( $scope, $http ) {

	$scope.project_id = $('#project_id').val();
	$scope.requirements = {};

	// Load requirements

	$scope.getRequirements = function () {

		$http.get( '/projects/' + $scope.project_id + '/requirements?format=json' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors == 'undefined' ) {

					$scope.requirements = r.data.requirements;

				}
			
			},

			function () {

			});

	};

	$scope.getRequirements();

	$scope.copy = function ( id ) {

		$http.post( '/projects/' + $scope.project_id + '/requirements/' + id + '/copy' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors == 'undefined' ) {

					_notify( 'Project requirement copied successfully.' );
					$scope.getRequirements();

				} else {

					_alert( r.data.errors, 1 );

				}
			
			},

			function () {

				_alert( 'Failed to copy project requirement.' );

			});

	};

	$scope.delete = function ( id ) {

		$http.delete( '/projects/' + $scope.project_id + '/requirements/' + id + '/delete' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors == 'undefined' ) {

					_notify( 'Project requirement deleted successfully.' );
					$scope.getRequirements();

				} else {

					_alert( r.data.errors, 1 );

				}
			
			},

			function () {

				_alert( 'Failed to delete project requirement.' );

			});

	};

}]);