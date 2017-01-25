app.controller('EditCaseCtrl', ['$scope', '$http', '$timeout', function ( $scope, $http, $timeout ) {

	$scope.project_id = $('#project_id').val();
	$scope.case_id = $('#case_id').val();
	$scope.case = {};

	$scope.getCase = function () {

		$id = $scope.case_id;

		$http.get( '/projects/' + $scope.project_id + '/cases/' + $id + '/get' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.case = r.data.case;

				}
			
			},

			function () {

				_alert( 'Failed to load test case.' );

			});

	};

	if ( $scope.case_id ) $scope.getCase();

	$scope.save = function () {

		$scope.saveAction( 0 );

	}

	$scope.saveClose = function () {

		$scope.saveAction( 1 );

	}

	$scope.saveAction = function ( close ) {

		$http.post( '/projects/' + $scope.project_id + '/cases/' + $scope.case_id + '/update', $scope.case ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {

					if ( close ) {
					
						location.assign( '/projects/' + $scope.project_id + '/cases' );

					} else {

						$scope.case = {};
						location.assign( '/projects/' + $scope.project_id + '/cases/new' );

					}

				}
			
			},

			function () {

				_alert( 'Failed to create test case.' );

			});

	};

	////////////////////////////////////////

		$scope.simulateQuery = false;
	  $scope.isDisabled    = false;

	  // list of `section` value/display objects
	  $scope.sections        		= [];
	  $scope.querySearch   			= querySearch;
	  $scope.selectedItemChange = selectedItemChange;
	  $scope.searchTextChange   = searchTextChange;

	  $scope.newSection = newSection;

	  $scope.loadSections = function ( project_id ) {

	    $http.get( '/projects/' + $scope.project_id + '/get-sections' ).then( 
				
				function ( r ) {
					
					if ( typeof r.data.errors != 'undefined' ) {

						_notify( r.data.errors, 1 );

					} else {

						$scope.sections = r.data.sections;	

						if ( typeof $scope.case.section_name === "string" ) {

							$timeout(function() {
								console.log('');
				        $scope.selectedItem = { name : $scope.case.section_name };
				    	}, 2000);

						}

					}
				
				},

				function () {

					_notify( 'Failed to load sections related to this project.' );

				});

	  }

	  $scope.loadSections( $scope.project_id );  

	  function newSection(section) {}

	  function querySearch (query) {
	  	searchTextChange(query);
	    var results = query ? $scope.sections.filter( createFilterFor(query) ) : $scope.sections,
	        deferred;
	    if ($scope.simulateQuery) {
	      deferred = $q.defer();
	      $timeout(function () { deferred.resolve( results ); }, Math.random() * 1000, false);
	      return deferred.promise;
	    } else {
	      return results;
	    }
	  }

	  function searchTextChange(text) {
	  	if ( typeof text != 'undefined' ) $scope.case.section_name = text;
	  }

	  function selectedItemChange(item) {

			if ( typeof item.name != 'undefined' ) $scope.case.section_name = item.name;

	  }

	  function createFilterFor(query) {
	    var lowercaseQuery = angular.lowercase(query);

	    return function filterFn(section) {
	      return (angular.lowercase(section.name).indexOf(lowercaseQuery) > -1);
	    };

	  }

  //////////////////////////////////

}]);