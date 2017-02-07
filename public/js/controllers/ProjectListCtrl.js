app.controller('ProjectListCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.projects = [];

	// Load projects

	$scope.getProjects = function () {

		$http.get( '/projects?format=json' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.projects = r.data.projects;

				}
			
			},

			function () {

				_alert( 'Failed to load projects.' );

			});

	};

	$scope.getProjects();

	$scope.project = {};

	// New project

  $scope.newProjectMode = false;

	$scope.newProject = function() {
    $scope.newProjectMode = true;
    $timeout( $('#new-project-title').focus(), 1000 );
  };

  $scope.cancelNewProject = function() {
    $scope.newProjectMode = false;
  };

	// Create project

	$scope.createProject = function () {

		console.log('hhh');

		$http.post( '/projects/create', $scope.project ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_error( r.data.errors, 1 );

				} else if ( typeof r.data.url != 'undefined' ) {
					
					location.assign( r.data.url );

				} else {
				
					$scope.project = {};
  				$scope.cancelNewProject();
					$scope.getProjects();

				}
			
			},

			function () {

				_alert( 'Failed to create project.' );

			});

	};

}]);