app.controller('ProjectTestLaunchCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();
	$scope.test_id = $( '#test_id').val();
	$scope.test_url = '/projects/' + $scope.project_id + '/tests/' + $( '#test_id').val();
	$scope.step_id = 0;
	$scope.activity_id = 0;

	$scope.getActivity = function () {

		$id = $scope.project_id;

		l(1);
		$http.get( '/projects/' + $id + '/tests/' + $scope.test_id + '/get-activity' ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
				
					$scope.step_id = r.data.step.id;
					$scope.activity_id = r.data.activity.id;
					$scope.step = r.data.step;
					$scope.activity = r.data.activity;
					$scope.case = r.data.case;
					$scope.scenario = r.data.scenario;

				}
			
			},

			function () {

				l(0);
		
				// _alert( 'Failed to load test activity.' );

			});

	};

	$scope.getActivity();

	$scope.passTest = function(ev) {

  	var confirm = $mdDialog.prompt()
      .title(_tt('Pass Test'))
      .textContent(_tt('Add a comment below to describe the result. Hit ESC to disregard this.'))
      .placeholder('')
      .ariaLabel(_tt('Test result description'))
      .targetEvent(ev)
      .ok(_tt('Post'))
      .cancel(_tt('Cancel'));

    $mdDialog.show(confirm).then(function(result) {
      
      $issueurl = $scope.test_url + '/activity/' + $scope.activity_id + '/step/' + $scope.step_id + '/create-issue';

      $http.post( $issueurl, { details : result, type : 'result' } ).then( 
				
				function ( r ) {
					
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						_notifySuccess( 'Successfully posted test result.' );
						$scope.getActivity();

					}
				
				},

				function () {

					_alert( 'Failed to post test result.' );

				});

    }, function() {

    		$issueurl = $scope.test_url + '/activity/' + $scope.activity_id + '/step/' + $scope.step_id + '/next-step';

	      $http.post( $issueurl ).then( 
					
					function ( r ) {
						
						if ( typeof r.data.errors != 'undefined' ) {

							_alert( r.data.errors, 1 );

						} else {

							$scope.getActivity();

						}
					
					},

					function () {

						_alert( 'Failed to advance test run.' );

					});

    });
  
  };

  $scope.skipStep = function () {

		$id = $scope.project_id;
  	$issueurl = $scope.test_url + '/activity/' + $scope.activity_id + '/step/' + $scope.step_id + '/skip-step';

		l(1);
		$http.post( $issueurl ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {

					$scope.getActivity();

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to skip test step.' );

			});

	};

  function FrameDialogCtrl($scope, $mdDialog) {
    $scope.hide = function() {
      $mdDialog.hide();
    };

    $scope.cancel = function() {
      $mdDialog.cancel();
    };

    $scope.answer = function(answer) {
      $mdDialog.hide(answer);
    };

  };

  $scope.failTest = function(ev) {

  	$issueurl = $scope.test_url + '/activity/' + $scope.activity_id + '/step/' + $scope.step_id + '/new-issue';

    $mdDialog.show({
      controller: FrameDialogCtrl,
      templateUrl: '/template?w=' + $(window).width() + '&h=' + $(window).height() + '&url=' + $issueurl,
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose:true,
      fullscreen: true
    })
    .then(function(answer) {
    }, function() {
    });
  
  };

}]);