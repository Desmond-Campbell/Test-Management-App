app.controller('ImportCasesCtrl', ['$scope', '$http', function ( $scope, $http ) {

	$scope.project_id = $('#project_id').val();
	$scope.caselist = '';
	$scope.section_name = '';

	$scope.import = function () {

		$scope.importAction( 0 );

	}

	$scope.importView = function () {

		$scope.importAction( 1 );

	}

	$scope.importAction = function ( view ) {

		$http.post( '/projects/' + $scope.project_id + '/cases/import', { 'cases' : $scope.caselist, 'section_name' : $scope.section_name } ).then( 
			
			function ( r ) {
				
				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {

					if ( view ) {
					
						location.assign( '/projects/' + $scope.project_id + '/cases' );

					} else {

						$scope.caselist = '';

					}

				}
			
			},

			function () {

				_alert( 'Failed to import test cases.' );

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
	  	if ( typeof text != 'undefined' ) $scope.section_name = text;
	  }

	  function selectedItemChange(item) {

			if ( typeof item.name != 'undefined' ) $scope.section_name = item.name;

	  }

	  function createFilterFor(query) {
	    var lowercaseQuery = angular.lowercase(query);

	    return function filterFn(section) {
	      return (angular.lowercase(section.name).indexOf(lowercaseQuery) > -1);
	    };

	  }

  //////////////////////////////////

}]);