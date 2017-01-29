app.controller('ProjectTeamListCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();

	// Load members

	$scope.getMembers = function () {

		$id = $scope.project_id;

		l(1);
		$http.get( '/projects/' + $id + '/team?format=json' ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.members = r.data.members;

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to load team members.' );

			});

	};

	$scope.getMembers();

}]);