app.controller('ProjectSuitesEditScenarioCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();
	$scope.scenario_id = $( '#scenario_id').val();
	$scope.suite_id = $( '#suite_id').val();
	$scope.scenario = {};

	// Load scenario

	$scope.getScenario = function () {

		$id = $scope.project_id;

		$http.get( '/projects/' + $id + '/suites/' + $scope.suite_id + '/get-scenario/' + $scope.scenario_id ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.scenario = r.data.scenario;

				}
			
			},

			function () {

				_alert( 'Failed to load test scenario.' );

			});

	};

	$scope.getScenario();

	$scope.save = function () {

		$id = $scope.project_id;

		l(1);
		$http.post( '/projects/' + $id + '/suites/' + $scope.suite_id + '/update-scenario/' + $scope.scenario_id, $scope.scenario ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
				
					pageconfig = $("#pageconfig").val();

					if ( pageconfig == 1 ) {

						$scope.scenario = {};
						$scope.cancel( r.data.result );

					} else {

						_notifySuccess( 'Scenario was updated successfully.' );

					}

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to save test scenario.' );

			});

	};

	$scope.cancel = function ( result ) {
		parent.passResult( result );
	};

	$scope.files = [];

	$scope.getScenarioFiles = function () {

		$http.get( '/projects/' + $id + '/suites/' + $scope.suite_id + '/get-scenario-files/' + $scope.scenario_id, $scope.scenario ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
				
					$scope.files = r.data.files;

				}
			
			},

			function () {

				_alert( 'Failed to load test files.' );

			});

	};

	//$scope.getScenarioFiles();

	$scope.uploadFileX = function( files) {
    	console.log( 'do upload' );
    
    var fd = new FormData();
    //Take the first selected file
    fd.append("file", files[0]);

    uploadUrl = '/projects/' + $id + '/suites/' + $scope.suite_id + '/scenario/' + $scope.scenario_id + '/upload-file';

    $http.post(uploadUrl, {
    		filedata : fd,
        withCredentials: true,
        headers: {'Content-Type': undefined },
        transformRequest: angular.identity
    }).then( function( r ) {
    	console.log( r.data, 'response' );
    }, function () {

    } );

	};

	var formdata = new FormData();
  $scope.getTheFiles = function ($files) {
      angular.forEach($files, function (value, key) {
          formdata.append(key, value);
      });
  };

  uploadUrl = '/projects/' + $id + '/suites/' + $scope.suite_id + '/scenario/' + $scope.scenario_id + '/upload-file';

  $scope.uploadFiles = function () {

    var request = {
        method: 'POST',
        url: uploadUrl,
        data: formdata,
        headers: {
            'Content-Type': undefined
        }
    };

    l(1);
    $http(request)
        .success(function (d) {
            $scope.getFiles();
            l(0);
        })
        .error(function () {
        		l(0);
        });
  };

  $scope.scenariofiles = [];

  $scope.getFiles = function () {

	  filesUrl = '/projects/' + $id + '/suites/' + $scope.suite_id + '/scenario/' + $scope.scenario_id + '/get-files';

	  $http.get( filesUrl ).then( function ( r ) {

	  	if ( typeof r.data.errors !== 'undefined' ) {

	  		_alert( r.data.errors );

	  	} else {

	  		$scope.scenariofiles = r.data.files;

	  	}

	  },

	  function () {

	  });

  };

  $scope.getFiles();

  $scope.deleteScenarioFile = function ( id ) {

	  filesUrl = '/projects/' + $id + '/suites/' + $scope.suite_id + '/scenario/' + $scope.scenario_id + '/file/' + id + '/delete';

	  $http.delete( filesUrl ).then( function ( r ) {

	  	if ( typeof r.data.errors !== 'undefined' ) {

	  		_alert( r.data.errors );

	  	} else {

	  		$scope.getFiles();

	  	}

	  },
	  
	  function () {

	  });

  }


}]);