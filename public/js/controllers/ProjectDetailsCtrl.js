app.controller('ProjectDetailsCtrl', ['$scope', '$http', 'fileUpload', function ( $scope, $http, fileUpload ) {

	$scope.project_types = [ 'Custom' ];

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

		l(1);

		$id = $scope.project_id;

		$http.get( '/projects/' + $id + '/details?format=json' ).then( 
			
			function ( r ) {
				
				l(0);
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.project = r.data.project;

				}
			
			},

			function () {

				l(0);
				_alert( 'Failed to load project.' );

			});

	};

	if ( $scope.project_id ) $scope.getProject();

	$scope.saveAndExit = function () {

		$scope.save( 1 );

	};

	$scope.justSave = function () {

		$scope.save( 0 );

	}

	$scope.save = function ( mode ) {

		l(1);

		console.log('save...');

		$id = $scope.project_id;

		$http.post( '/projects/' + $id + '/details/update', $scope.project ).then( 
			
			function ( r ) {

				l(0);
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {

					if ( mode ) {

						location.assign( '/projects/' + $id + '/dashboard' );

					}
					
					_notifySuccess( 'Project details saved successfully.', 'success' );

				}
			
			},

			function () {

				l(0);
				_alert( 'Failed to update project details.' );

			});

	};

	// Handle logo requests

	$scope.logoFile = null;
	$scope.logoPath = '/img/icon.png';

	$scope.saveLogo = function(){
	  var file = $scope.logoFile;
	  console.log('file is ' );
	  console.dir(file);
	  var uploadUrl = '/projects/' + $scope.project_id + '/upload-logo';
	  fileUpload.uploadFileToUrl(file, uploadUrl);
  };

}]);