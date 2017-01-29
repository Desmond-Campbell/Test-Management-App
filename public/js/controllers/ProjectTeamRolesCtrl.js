app.controller('ProjectTeamRolesCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();

	// Load roles

	$scope.getRoles = function () {

		$id = $scope.project_id;

		l(1);
		$http.get( '/projects/' + $id + '/team/roles?format=json' ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.roles = r.data.roles;

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to load roles.' );

			});

	};

	$scope.getRoles();

}]);