app.controller('ImportCasesCtrl', ['$scope', '$http', function ( $scope, $http ) {

	$scope.project_id = $('#project_id').val();
	$scope.caselist = '';

	$scope.import = function () {

		$scope.importAction( 0 );

	}

	$scope.importView = function () {

		$scope.importAction( 1 );

	}

	$scope.importAction = function ( view ) {

		$http.post( '/projects/' + $scope.project_id + '/cases/import', { 'cases' : $scope.caselist } ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {

					if ( view ) {
					
						location.assign( '/projects/' + $scope.project_id + '/cases' );

					} else {

						$scope.caselist = '';

					}

				}
			
			},

			function () {

				_alert( 'Failed to import test cases.' );

			});

	};

}]);