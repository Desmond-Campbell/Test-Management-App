app.controller('EditRequirementCtrl', ['$scope', '$http', '$timeout', function ( $scope, $http, $timeout ) {

	$scope.project_id = $('#project_id').val();
	$scope.requirement_id = $('#requirement_id').val();
	$scope.requirement = {};

	$scope.getRequirement = function () {

		$id = $scope.requirement_id;

		$http.get( '/projects/' + $scope.project_id + '/requirements/' + $id + '/get' ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.requirement = r.data.requirement;

				}
			
			},

			function () {

				_alert( 'Failed to load project requirement.' );

			});

	};

	if ( $scope.requirement_id ) $scope.getRequirement();

	$scope.save = function () {

		$scope.saveAction( 0 );

	}

	$scope.saveClose = function () {

		$scope.saveAction( 1 );

	}

	$scope.saveAction = function ( close ) {

		$http.post( '/projects/' + $scope.project_id + '/requirements/' + $scope.requirement_id + '/update', $scope.requirement ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {

					if ( close ) {
					
						location.assign( '/projects/' + $scope.project_id + '/requirements' );

					} else {

						$scope.requirement = {};
						location.assign( '/projects/' + $scope.project_id + '/requirements/new' );

					}

				}
			
			},

			function () {

				_alert( 'Failed to update project requirement.' );

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

	    $http.get( '/projects/' + $scope.project_id + '/get-requirement-sections' ).then( 
				
				function ( r ) {
					
					if ( typeof r.data.errors != 'undefined' ) {

						_notify( r.data.errors, 1 );

					} else {

						$scope.sections = r.data.sections;	

						if ( typeof $scope.requirement.section_name === "string" ) {

							$timeout(function() {
								console.log('');
				        $scope.selectedItem = { name : $scope.requirement.section_name };
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
	  	if ( typeof text != 'undefined' ) $scope.requirement.section_name = text;
	  }

	  function selectedItemChange(item) {

			if ( typeof item.name != 'undefined' ) $scope.requirement.section_name = item.name;

	  }

	  function createFilterFor(query) {
	    var lowercaseQuery = angular.lowercase(query);

	    return function filterFn(section) {
	      return (angular.lowercase(section.name).indexOf(lowercaseQuery) > -1);
	    };

	  }

  //////////////////////////////////

  ////////////////////////////////////////

	  // list of `requirements` value/display objects
	  $scope.requirements       = [];
	  $scope.querySearchR   			= querySearchR;
	  $scope.selectedItemChangeR = selectedItemChangeR;
	  $scope.searchTextChangeR   = searchTextChangeR;

	  $scope.newRequirement = newRequirement;

	  $scope.loadRequirements = function ( project_id ) {

	    $http.get( '/projects/' + $scope.project_id + '/requirements?format=json&restrict-level=1&unsorted=1' ).then( 
				
				function ( r ) {
					
					if ( typeof r.data.errors != 'undefined' ) {

						_notify( r.data.errors, 1 );

					} else {

						$scope.requirements = r.data.requirements;	

						if ( typeof $scope.requirement.parent_requirement_name === "string" ) {

							$timeout(function() {
								console.log('');
				        $scope.selectedItemR = { summary : $scope.requirement.parent_requirement_name };
				    	}, 2000);

						}

					}
				
				},

				function () {

					_notify( 'Failed to load requirements related to this project.' );

				});

	  }

	  $scope.loadRequirements( $scope.project_id );  

	  function newRequirement(requirement) {}

	  function querySearchR (query) {
	  	searchTextChangeR(query);
	    var results = query ? $scope.requirements.filter( createFilterForR(query) ) : $scope.requirements,
	        deferred;
	    if ($scope.simulateQuery) {
	      deferred = $q.defer();
	      $timeout(function () { deferred.resolve( results ); }, Math.random() * 1000, false);
	      return deferred.promise;
	    } else {
	      return results;
	    }
	  }

	  function searchTextChangeR(text) {
	  	if ( typeof text != 'undefined' ) $scope.requirement.parent_requirement_name = text;
	  }

	  function selectedItemChangeR(item) {

			if ( typeof item != 'undefined' ) {

				if ( typeof item.summary != 'undefined' ) $scope.requirement.parent_requirement_name = item.summary;

			}

	  }

	  function createFilterForR(query) {
	    var lowercaseQuery = angular.lowercase(query);

	    return function filterFn(requirement) {
	      return (angular.lowercase(requirement.summary).indexOf(lowercaseQuery) > -1);
	    };

	  }

  //////////////////////////////////

}]);