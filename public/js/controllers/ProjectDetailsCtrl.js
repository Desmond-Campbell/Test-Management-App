app.controller('ProjectDetailsCtrl', ['$scope', '$http', function ( $scope, $http ) {

	$scope.project_types = [ { id : 1, label : 'Custom' } ];

	// Load project types

	$scope.getProjectTypes = function () {

		$http.get( '/lists/project-types/f:json' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors == 'undefined' ) {

					$scope.project_types = r.data.list;

				}
			
			},

			function () {

			});

	};

	$scope.getProjectTypes();

	// Set up project

	$scope.project = {};

	$scope.project_id = $( '#project_id').val();

	$scope.getProject = function () {

		$id = $scope.project_id;

		$http.get( '/projects/' + $id + '/details?format=json' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.project = r.data.project;

				}
			
			},

			function () {

				_alert( 'Failed to load project.' );

			});

	};

	if ( $scope.project_id ) $scope.getProject();

	$scope.save = function () {

		$id = $scope.project_id;

		$http.post( '/projects/' + $id + '/details/update', $scope.project ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					_notify( 'Project details saved successfully.' );

				}
			
			},

			function () {

				_alert( 'Failed to update project details.' );

			});

	};

}]);