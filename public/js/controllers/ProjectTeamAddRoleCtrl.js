app.controller('ProjectTeamAddRoleCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();

	$scope.save = function ( user_id ) {

		l(1);

		$id = $scope.project_id;

		$http.post( '/projects/' + $id + '/team/create-role', $scope.role ).then( 
			
			function ( r ) {
				
				l(0);

				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.role = {};

					if ( typeof r.data.result_id != 'undefined' ) {

						location.assign( '/projects/' + $id + '/team/' + r.data.result_id + '/edit-role' );

					} else {

						location.assign( '/projects/' + $id + '/team/roles' );

					}

				}
			
			},

			function () {

				l(0);

				_alert( 'Failed to add role to this project.' );

			});

	};

	$scope.getRoles = function () {

		$id = $scope.project_id;

		l(1);
		$http.get( '/projects/' + $id + '/team/roles?format=json&request-type=namesonly' ).then( 
			
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