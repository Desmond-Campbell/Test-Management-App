app.controller('ProjectBatchListCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();
	$scope.test_id = $( '#test_id').val();
	$scope.batches = [];

	$scope.getBatches = function() {

  	$http.get( '/projects/' + $scope.project_id + '/tests/' + $scope.test_id + '/get-batches' ).then( 
				
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.batches = r.data.batches;

				}
			
			},

			function () {

				_alert( 'Failed to load test batches.' );

			});

  }

	$scope.getBatches();

	$scope.stopBatch = function( id, index ) {

  	$http.post( '/projects/' + $scope.project_id + '/tests/' + $scope.test_id + '/stop-batch/' + id ).then( 
				
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.batches[index].status = 0;

				}
			
			},

			function () {

				_alert( 'Failed to load stop batch.' );

			});

  }

  $scope.startBatch = function() {

  	$http.post( '/projects/' + $scope.project_id + '/tests/' + $scope.test_id + '/start-batch' ).then( 
				
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.getBatches();

				}
			
			},

			function () {

				_alert( 'Failed to start test batch.' );

			});

  }

}]);