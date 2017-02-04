app.controller('ProjectBatchResultsCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();
	$scope.test_id = $( '#test_id').val();
	$scope.batch_id = $( '#batch_id').val();
	$scope.results = [];

	$scope.getResults = function() {

  	$http.get( '/projects/' + $scope.project_id + '/tests/' + $scope.test_id + '/batch/' + $scope.batch_id + '/get-results' ).then( 
				
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.results = r.data.results;

				}
			
			},

			function () {

				_alert( 'Failed to load test results.' );

			});

  }

	$scope.getResults();

}]);