app.controller('NewProjectCtrl', ['$scope', '$http', function ( $scope, $http ) {

	$scope.project = {};
	$scope.project_types = [ { id : 1, label : 'Custom' } ];

	$scope.save = function () {

		$http.post( '/projects/create', $scope.project ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					location.assign( '/projects/' + r.data.result_id + '/dashboard' );

				}
			
			},

			function () {

				_alert( 'Failed to create project.' );

			});

	};

}]);