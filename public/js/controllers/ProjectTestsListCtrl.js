app.controller('ProjectTestsListCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();

	$scope.addTest = function(ev) {

	  	var confirm = $mdDialog.prompt()
	      .title(_tt('Name your new test below.'))
	      .textContent(_tt('Afterwards, you can add test cases, testers and more.'))
	      .placeholder('')
	      .ariaLabel(_tt('Test name'))
	      .targetEvent(ev)
	      .ok(_tt('Create'))
	      .cancel(_tt('Cancel'));

	    $mdDialog.show(confirm).then(function(result) {
	      
	      $http.post( '/projects/' + $scope.project_id + '/tests/create', { name : result } ).then( 
					
					function ( r ) {
						
						if ( typeof r.data.errors != 'undefined' ) {

							_alert( r.data.errors, 1 );

						} else {
							
							if ( typeof r.data.result_id != 'undefined' ) {

								location.assign( '/projects/' + $scope.project_id + '/tests/' + r.data.result_id );

							} else {

								location.assign( '/projects/' + $scope.project_id + '/tests' );
								
							}

						}
					
					},

					function () {

						_alert( 'Failed to create test run.' );

					});

	    }, function() {
	    	
	    });
	  
	  };

}]);