app.controller('ProjectTeamAddCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();

	$scope.hide_members = false;

	$scope.changeFilter = function () {

		if ( !$scope.hide_members ) {
			
			$scope.getPeople( '1' );

		} else {

			$scope.getPeople( '-1' );

		}

	}

	// Load people
	$scope.people = {};

	$scope.getPeople = function ( filter ) {

		l(1);

		$id = $scope.project_id;

		$http.get( '/network/people?project_id=' + $id + '&format=json&filter_members=' + filter ).then( 
			
			function ( r ) {
				
				l(0);

				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.people = r.data.people;

				}

				if ( typeof r.data.filter_members != 'undefined' ) {

					$scope.hide_members = r.data.filter_members;

				}
			
			},

			function () {

				l(0);

				_alert( 'Failed to find people in your network.' );

			});

	};

	$scope.getPeople( '' );

	$scope.createMember = function ( user_id ) {

		l(1);

		$id = $scope.project_id;

		$http.post( '/projects/' + $id + '/team/create-member', { user_id : user_id} ).then( 
			
			function ( r ) {
				
				l(0);

				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.getPeople( '' );

				}
			
			},

			function () {

				l(0);

				_alert( 'Failed to add member to project team.' );

			});

	};

}]);