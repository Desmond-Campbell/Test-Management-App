app.controller('SuitesCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();
	$scope.suites = [];
	$scope.suites_url = '/projects/' + $scope.project_id + '/suites/';

	// Load suites

	$scope.getSuites = function () {

		$id = $scope.project_id;

		l(1);
		$http.get( '/projects/' + $id + '/suites?format=json' ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.suites = r.data.suites;

					target_suite_id = $( '#suite_id').val();
					
					if ( target_suite_id ) {

						$scope.getSuite( target_suite_id );

					}

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to load test suites.' );

			});

	};

	$scope.getSuites();

	// Load suite

		$scope.suite = {};

		$scope.getSuite = function ( id ) {

			$id = $scope.project_id;

			$scope.suite = {};
			$scope.scenarios = [];
			$scope.scenario = {};
			$scope.cases = [];
			$scope.case = {};

			$http.get( $scope.suites_url + id + '/get' ).then( 
				
				function ( r ) {
					
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.suite = r.data.suite;
						$scope.getScenarios();

					}
				
				},

				function () {

					_alert( 'Failed to load test suite requested.' );

				});

		};

		$scope.editSuite = function(id) {

    	$suiteurl = $scope.suites_url + id + '/edit';
	    $mdDialog.show({
	      controller: FrameDialogCtrl,
	      templateUrl: '/template?w=' + $(window).width() + '&h=' + $(window).height() + '&url=' + $suiteurl,
	      parent: angular.element(document.body),
	      clickOutsideToClose:true,
	      fullscreen: true
	    })
	    .then(function(answer) {
	    }, function() {
	    });

	  };

	  $scope.deleteSuite = function (id) {

			if ( !getconfirm() ) return;

			$id = $scope.project_id;

			l(1);
			$http.delete( '/projects/' + $id + '/suites/' + id + '/delete' ).then( 
				
				function ( r ) {
					
					l(0);
			
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.getSuites();

					}
				
				},

				function () {

					l(0);
			
					_alert( 'Failed to delete test suite.' );

				});

		};

	// Load scenarios

		$scope.scenarios = [];

		$scope.getScenarios = function ( id ) {

			$scope.scenarios = [];
			$scope.scenario = {};
			$scope.cases = [];
			$scope.case = {};

			if ( typeof $scope.suite === 'undefined' || $scope.suite === null ) return;
			if ( typeof $scope.suite.id === 'undefined' ) return;

			$id = $scope.project_id;
			$suite_id = $scope.suite.id;

			l(1);
			$http.get( $scope.suites_url + $suite_id + '/get-scenarios' ).then( 
				
				function ( r ) {
					
					l(0);
			
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.scenarios = r.data.scenarios;

						if ( id ) $scope.getScenario( id );

						target_scenario_id = $( '#scenario_id').val();
					
						if ( target_scenario_id ) {

							$scope.getScenario( target_scenario_id );

						}

					}
				
				},

				function () {

					l(0);
			
					_alert( 'Failed to load test scenarios requested.' );

				});

		};

	// Load scenario

		$scope.scenario = {};

		$scope.getScenario = function ( id ) {

			$scope.scenario = {};
			$scope.cases = [];
			$scope.case = {};

			$id = $scope.project_id;
			
			if ( typeof $scope.suite === 'undefined' || $scope.suite === null ) return;
			if ( typeof $scope.suite.id === 'undefined' ) return;

			$http.get( $scope.suites_url + $suite_id + '/get-scenario/' + id ).then( 
				
				function ( r ) {
					
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.scenario = r.data.scenario;
						$scope.getCases();

					}
				
				},

				function () {

					_alert( 'Failed to load test scenario requested.' );

				});

		};

	// Edit scenario

		$scope.editScenario = function(id) {

    	$scenariourl = $scope.suites_url + $scope.suite.id + '/edit-scenario/' + id;
	    $mdDialog.show({
	      controller: FrameDialogCtrl,
	      templateUrl: '/template?w=' + $(window).width() + '&h=' + $(window).height() + '&url=' + $scenariourl,
	      parent: angular.element(document.body),
	      clickOutsideToClose:true,
	      fullscreen: true
	    })
	    .then(function(answer) {
	    }, function() {
	    });
	  };

	  $scope.deleteScenario = function (id) {

			if ( !getconfirm() ) return;
		
			$id = $scope.project_id;
    	$scenariourl = $scope.suites_url + $scope.suite.id + '/delete-scenario/' + id;

			l(1);
			$http.delete( $scenariourl ).then( 
				
				function ( r ) {
					
					l(0);
			
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.getScenarios();

					}
				
				},

				function () {

					l(0);
			
					_alert( 'Failed to delete test scenario.' );

				});

		};

	  $scope.addScenario = function(ev) {

	  	err = 0;

	  	if ( typeof $scope.suite === 'undefined' || $scope.suite === null ) err = 1;
			if ( typeof $scope.suite.id === 'undefined' ) err = 1;

			if ( err ) {

				_alert( 'Please select a test suite first.' );

				return;

			}

    	var confirm = $mdDialog.prompt()
	      .title(_tt('Name your new scenario below.'))
	      .textContent(_tt('Afterwards, you can add more information, including photos.'))
	      .placeholder('')
	      .ariaLabel(_tt('Scenario name'))
	      .targetEvent(ev)
	      .ok(_tt('Create'))
	      .cancel(_tt('Cancel'));

	    $mdDialog.show(confirm).then(function(result) {
	      
	      $http.post( $scope.suites_url + $scope.suite.id + '/create-scenario', { name : result } ).then( 
					
					function ( r ) {
						
						if ( typeof r.data.errors != 'undefined' ) {

							_alert( r.data.errors, 1 );

						} else {
							
							if ( typeof r.data.result_id != 'undefined' ) {

								$scope.getScenarios( r.data.result_id );

							} else {

								$scope.getScenarios();

							}

						}
					
					},

					function () {

						_alert( 'Failed to create test scenario.' );

					});
	    }, function() {
	    });
	  
	  };

	// Load cases

		$scope.cases = [];

		$scope.getCases = function () {

			$scope.cases = [];
			$scope.case = {};

			if ( typeof $scope.suite === 'undefined' || $scope.suite === null ) return;
			if ( typeof $scope.suite.id === 'undefined' ) return;
			if ( typeof $scope.scenario === 'undefined' || $scope.scenario === null ) return;
			if ( typeof $scope.scenario.id === 'undefined' ) return;
			
			$id = $scope.project_id;
			$suite_id = $scope.suite.id;
			$scenario_id = $scope.scenario.id;

			l(1);
			$http.get( $scope.suites_url + $suite_id + '/get-cases/' + $scenario_id ).then( 
				
				function ( r ) {
					
					l(0);
			
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.cases = r.data.cases;

					}
				
				},

				function () {

					l(0);
			
					_alert( 'Failed to load test cases requested.' );

				});

		};

	// Load case

		$scope.cases = [];

		$scope.getCase = function ( id ) {

			$scope.case = {};

			if ( typeof $scope.suite === 'undefined' || $scope.suite === null ) return;
			if ( typeof $scope.suite.id === 'undefined' ) return;
			if ( typeof $scope.scenario === 'undefined' || $scope.scenario === null ) return;
			if ( typeof $scope.scenario.id === 'undefined' ) return;

			$id = $scope.project_id;
			$suite_id = $scope.suite.id;

			l(1);
			$http.get( $scope.suites_url + $suite_id + '/get-case/' + id ).then( 
				
				function ( r ) {
					
					l(0);
			
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.case = r.data.case;

					}
				
				},

				function () {

					l(0);
			
					_alert( 'Failed to load test case requested.' );

				});

		};

		$scope.suiteClass = function ( suite_id ) {

			if ( typeof $scope.suite === 'undefined' || $scope.suite === null ) return;
			if ( typeof $scope.suite.id === 'undefined' ) return;

			if ( $scope.suite.id == suite_id ) return 'active-item';
			
		};

		$scope.scenarioClass = function ( suite_id ) {

			if ( typeof $scope.scenario === 'undefined' || $scope.scenario === null ) return;
			if ( typeof $scope.scenario.id === 'undefined' ) return;
			
			if ( $scope.scenario.id == suite_id ) return 'active-item';

		};

		$scope.caseClass = function ( case_id ) {

			if ( typeof $scope.case === 'undefined' || $scope.case === null ) return;
			if ( typeof $scope.case.id === 'undefined' ) return;
			
			if ( $scope.case.id == case_id ) return 'active-item';

		};

		//////

		$scope.hassuites = function () {

			if ( typeof $scope.suites === 'undefined' || $scope.suites === null ) return false;

			return $scope.suites.length > 0;
			
		};

		$scope.activesuite = function () {

			return !( typeof $scope.suite === 'undefined' || $scope.suite === null );
			
		};

		$scope.hasscenarios = function () {

			if ( typeof $scopescenarios === 'undefined' || $scopescenarios === null ) return false;

			return $scopescenarios.length > 0;
			
		};

		$scope.activescenario = function () {

			return !( typeof $scope.scenario === 'undefined' || $scope.scenario === null );
			
		};

		$scope.hascases = function () {

			if ( typeof $scope.cases === 'undefined' || $scope.cases === null ) return false;

			return $scope.cases.length > 0;
			
		};

		/////////////

		$scope.showSuiteMenu = function ( suite_id ) {

			alert (suite_id );

		};

		$scope.openMenu = function($mdOpenMenu, ev) {
      originatorEv = ev;
      $mdOpenMenu(ev);
    };

    ///////////////

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

    $scope.editCase = function(ev, id) {

    	$caseurl = $scope.suites_url + $scope.suite.id + '/edit-case/' + id;
	    $mdDialog.show({
	      controller: FrameDialogCtrl,
	      templateUrl: '/template?w=' + $(window).width() + '&h=' + $(window).height() + '&url=' + $caseurl,
	      parent: angular.element(document.body),
	      targetEvent: ev,
	      clickOutsideToClose:true,
	      fullscreen: true
	    })
	    .then(function(answer) {
	    }, function() {
	    });
	  };

	  $scope.deleteCase = function (id) {

			if ( !getconfirm() ) return;
		
			$id = $scope.project_id;
    	$caseurl = $scope.suites_url + $scope.suite.id + '/scenario/' + $scope.scenario.id + '/delete-case/' + id;

			l(1);
			$http.delete( $caseurl ).then( 
				
				function ( r ) {
					
					l(0);
			
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.getCases();

					}
				
				},

				function () {

					l(0);
			
					_alert( 'Failed to delete test case.' );

				});

		};

	  $scope.addCase = function(ev) {

    	err = 0;

	  	if ( typeof $scope.suite === 'undefined' || $scope.suite === null ) err = 1;
			if ( typeof $scope.suite.id === 'undefined' ) err = 1;

			if ( err ) {

				_alert( 'Please select a test suite first.' );

				return;

			}

			if ( typeof $scope.scenario === 'undefined' || $scope.scenario === null ) err = 1;
			if ( typeof $scope.scenario.id === 'undefined' ) err = 1;

			if ( err ) {

				_alert( 'Please select a test scenario first.' );

				return;

			}

    	var confirm = $mdDialog.prompt()
	      .title(_tt('Name your new test case below.'))
	      .textContent(_tt('A test case is an actual test for a test condition or scenario.'))
	      .placeholder('')
	      .ariaLabel(_tt('Test case name'))
	      .targetEvent(ev)
	      .ok(_tt('Create'))
	      .cancel(_tt('Cancel'));

	    $mdDialog.show(confirm).then(function(result) {
	      
	      $http.post( $scope.suites_url + $suite_id + '/create-case/' + $scope.scenario.id, { name : result } ).then( 
					
					function ( r ) {
						
						if ( typeof r.data.errors != 'undefined' ) {

							_alert( r.data.errors, 1 );

						} else {
							
							if ( typeof r.data.result_id != 'undefined' ) {

								$scope.getCases();
								$scope.editCase( null, r.data.result_id );

							} else {
			
								$scope.getCases();

							}

						}
					
					},

					function () {

						_alert( 'Failed to create test case.' );

					});
	    }, function() {
	    });
	  
	  };

}]);
