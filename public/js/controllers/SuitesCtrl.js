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
						$scope.getScenarios( id );

					}
				
				},

				function () {

					_alert( 'Failed to load test suite requested.' );

				});

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

			l(1);
			$http.get( $scope.suites_url + $suite_id + '/get-scenarios' ).then( 
				
				function ( r ) {
					
					l(0);
			
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.scenarios = r.data.scenarios;

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

    function EditCaseCtrl($scope, $mdDialog) {
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
	      controller: EditCaseCtrl,
	      templateUrl: '/template?w=' + $(window).width() + '&h=' + $(window).height() + '&url=' + $caseurl,
	      parent: angular.element(document.body),
	      targetEvent: ev,
	      clickOutsideToClose:true,
	      fullscreen: true
	    })
	    .then(function(answer) {
	      $scope.status = 'You said the information was "' + answer + '".';
	    }, function() {
	      $scope.status = 'You cancelled the dialog.';
	    });
	  };

}]);

function receiveResult( result ){

	$('md-backdrop').hide();
	$('.md-dialog-container').hide();
	$('.md-scroll-mask').hide();

}