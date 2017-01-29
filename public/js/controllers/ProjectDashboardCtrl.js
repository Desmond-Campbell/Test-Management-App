app.controller('ProjectDashboardCtrl', ['$scope', '$http', '$mdDialog', '$timeout', '$sce', function ( $scope, $http, $mdDialog, $timeout, $sce ) {

	$scope.project_id = $( '#project_id').val();
	$scope.activities = [];

	$scope.getActivites = function () {

		l(1);

		$id = $scope.project_id;

		$http.get( '/projects/' + $id + '/activities' ).then( 
			
			function ( r ) {

				l(0);
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.activities = r.data.activities;

				}
			
			},

			function () {

				l(0);
				_alert( 'Failed to load activities.' );

			});

	};

	$scope.getActivites();

}]);