app.controller('ProjectListCtrl', ['$scope', '$http', function ( $scope, $http ) {

	$scope.projects = [];

	// Load projects

	$scope.getProjects = function () {

		$http.get( '/projects?format=json' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.projects = r.data.projects;

				}
			
			},

			function () {

				_alert( 'Failed to load projects.' );

			});

	};

	$scope.getProjects();

}]);