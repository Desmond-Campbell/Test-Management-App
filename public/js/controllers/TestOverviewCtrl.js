app.controller('TestOverviewCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();
	$scope.test_id = $( '#test_id').val();
	$scope.test = [];

	// Get test

	$scope.getTest = function () {

		$id = $scope.project_id;

		l(1);
		$http.get( '/projects/' + $id + '/tests/' + $scope.test_id + '/get' ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.test = r.data.test;

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to load test run.' );

			});

	};

	$scope.getTest();

	// Load suites

	$scope.getBundle = function () {

		$id = $scope.project_id;

		l(1);
		$http.get( '/projects/' + $id + '/tests/' + $scope.test_id + '/get-bundle?format=json' ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.suites = r.data.suites;
					$scope.scenarios = [];
					$scope.stockscenarios = r.data.scenarios;
					$scope.cases = [];
					$scope.stockcases = r.data.cases;

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to load test cases.' );

			});

	};

	$scope.getBundle();

	// Load suite

		$scope.suite = {};

		$scope.getSuite = function ( id ) {

			$id = $scope.project_id;

			$scope.suite = {};
			$scope.scenarios = [];
			$scope.scenario = {};
			$scope.cases = [];
			$scope.case = {};

			for ( s = 0; s < $scope.suites.length; s++ ) {

				suite = $scope.suites[s];

				if ( suite.id == id ) {

					$scope.suite = suite;
					$scope.suite_index = s;

				}

			}

			$scope.getScenarios();

		};

	// Load scenarios

		$scope.scenarios = [];

		$scope.getScenarios = function () {

			$scope.scenarios = [];
			$scope.scenario = {};
			$scope.cases = [];
			$scope.case = {};

			if ( typeof $scope.suite === 'undefined' || $scope.suite === null ) return;
			if ( typeof $scope.suite.id === 'undefined' ) return;

			$id = $scope.project_id;
			$suite_id = $scope.suite.id;

			for ( s = 0; s < $scope.stockscenarios.length; s++ ) {

				scenario = $scope.stockscenarios[s];

				if ( scenario.suite_id == $suite_id ) {

					$scope.scenarios.push( scenario );

				}

			}

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

			for ( s = 0; s < $scope.stockscenarios.length; s++ ) {

				scenario = $scope.stockscenarios[s];

				if ( scenario.id == id ) {

					$scope.scenario = scenario;
					$scope.scenario_index = s;

				}

			}

			$scope.getCases();

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

			for ( c = 0; c < $scope.stockcases.length; c++ ) {

				testcase = $scope.stockcases[c];

				if ( testcase.scenario_id == $scope.scenario.id ) {

					$scope.cases.push( testcase );

				}

			}

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

	  $scope.filter_select = function ( list, field, id, setvalue ) {

	  	for ( s = 0; s < $scope[list].length; s++ ) {

  			target = $scope[list][s];

  			if ( target[field] == id ) {

  				$scope[list][s].selected = setvalue;

  			}

  		}

	  }

	  $scope.hasSuiteWith = function ( id ) {
	  	
	  	for ( s = 0; s < $scope.suites.length; s++ ) {

  			suite = $scope.suites[s];

  			if ( suite.id == id ) {

  				return suite.selected;

  			}

  		}

  		return false;

	  };

	  $scope.toggleSuiteSelection = function ( id ) {

  		for ( s = 0; s < $scope.suites.length; s++ ) {

  			suite = $scope.suites[s];

  			if ( suite.id == id ) {

  				$scope.suites[s].selected = !$scope.suites[s].selected;

  				$scope.filter_select( 'stockscenarios', 'suite_id', id, $scope.suites[s].selected );

  			}

  		}
  	
  	};

  	$scope.hasScenarioWith = function ( id ) {
	  	
	  	for ( s = 0; s < $scope.stockscenarios.length; s++ ) {

  			scenario = $scope.stockscenarios[s];

  			if ( scenario.id == id ) {

  				return scenario.selected;

  			}

  		}

  		return false;

	  };

	  $scope.toggleScenarioSelection = function ( id, setvalue ) {

	  	for ( s = 0; s < $scope.stockscenarios.length; s++ ) {

  			scenario = $scope.stockscenarios[s];

  			if ( scenario.id == id ) {

  				$scope.stockscenarios[s].selected = !$scope.stockscenarios[s].selected;

  				$scope.filter_select( 'stockcases', 'scenario_id', scenario.id, $scope.stockscenarios[s].selected );

  			}

  		}
  	
  	};

	  $scope.hasCaseWith = function ( id ) {
	  	
	  	for ( s = 0; s < $scope.stockcases.length; s++ ) {

  			testcase = $scope.stockcases[s];

  			if ( testcase.id == id ) {

  				return testcase.selected;

  			}

  		}

  		return false;

	  };

	  $scope.toggleCaseSelection = function ( id ) {

	  	for ( c = 0; c < $scope.stockcases.length; c++ ) {

  			testcase = $scope.stockcases[c];

  			if ( testcase.id == id ) {

  				$scope.stockcases[c].selected = !$scope.stockcases[c].selected;

  			}

  		}
  	
  	};

	$scope.save = function () {

		$id = $scope.project_id;

		l(1);
		$http.post( '/projects/' + $id + '/tests/' + $scope.test_id + '/update', $scope.test ).then( 
			
			function ( r ) {
				
				l(0);
		
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
				
					pageconfig = $("#pageconfig").val();

					if ( pageconfig != 'template-full' ) {

						_notifySuccess( 'Test was updated successfully.' );

					} else {

						$scope.test = {};
						$scope.cancel( r.data.result );

					}

				}
			
			},

			function () {

				l(0);
		
				_alert( 'Failed to save test.' );

			});

	};

	$scope.cancel = function ( result ) {
		parent.passResult( result );
	};

}]);

function receiveResult( result ){

	$('md-backdrop').hide();
	$('.md-dialog-container').hide();
	$('.md-scroll-mask').hide();

}