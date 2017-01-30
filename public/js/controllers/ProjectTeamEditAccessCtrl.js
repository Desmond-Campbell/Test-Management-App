app.controller('ProjectTeamEditAccessCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();
	$scope.member_id = $( '#member_id').val();

	// Remove member

	$scope.removeMember = function () {

		l(1);

		$id = $scope.project_id;
		$member_id = $scope.member_id;

		$http.post( '/projects/' + $id + '/team/' + $member_id + '/remove-member' ).then( 
			
			function ( r ) {
				
				l(0);

				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.dirty_roles = false;
					to( '/projects/' + $id + '/team' );

				}
			
			},

			function () {

				l(0);

				_alert( 'Failed to remove team member.' );

			});

	};

	// Checkbox functions for roles		

		$scope.roles = [];
		$scope.selected = [];
		$scope.role_info = {};
	  $scope.dirty_roles = false;

		$scope.getRoles = function ( filter ) {

	  	$scope.dirty_roles = false;
			$id = $scope.project_id;
			$member_id = $scope.member_id;

			$http.get( '/projects/' + $id + '/team/' + $member_id + '/get-roles' ).then( 
				
				function ( r ) {
					
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.roles = r.data.roles;
						$scope.selected = r.data.selected_roles;
						$scope.role_info = r.data.role_info;

					}
				
				},

				function () {

					_alert( 'Failed to load roles for this team.' );

				});

		};

		$scope.getRoles();

	  $scope.toggle = function (role, list) {
	  	$scope.dirty_roles = true;
	    var idx = list.indexOf(role);
	    if (idx > -1) {
	      list.splice(idx, 1);
	    }
	    else {
	      list.push(role);
	    }
	  };

	  $scope.exists = function (role, list) {
	    return list.indexOf(role) > -1;
	  };

	  $scope.isIndeterminate = function() {
	    return ($scope.selected.length !== 0 &&
	        $scope.selected.length !== $scope.roles.length);
	  };

	  $scope.isChecked = function() {
	    return $scope.selected.length === $scope.roles.length;
	  };

	  $scope.toggleAll = function() {
	  	$scope.dirty_roles = true;
	    if ($scope.selected.length === $scope.roles.length) {
	      $scope.selected = [];
	    } else if ($scope.selected.length === 0 || $scope.selected.length > 0) {
	      $scope.selected = $scope.roles.slice(0);
	    }
	  };

	  $scope.saveRoles = function () {

			l(1);

			$id = $scope.project_id;
			$member_id = $scope.member_id;

			$http.post( '/projects/' + $id + '/team/' + $member_id + '/save-roles', { 'selected_roles' : $scope.selected } ).then( 
				
				function ( r ) {
					
					l(0);

					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.dirty_roles = false;
						_notifySuccess( 'Roles updated successfully.' );

					}
				
				},

				function () {

					l(0);

					_alert( 'Failed to update roles for this team member.' );

				});

		};

	// Checkbox functions for overrides

		$scope.overrides = [];
		$scope.selectedO = [];
		$scope.override_info = {};
	  $scope.dirty_overrides = false;

		$scope.getOverrides = function ( filter ) {

	  	$scope.dirty_overrides = false;
			$id = $scope.project_id;
			$member_id = $scope.member_id;

			$http.get( '/projects/' + $id + '/team/' + $member_id + '/get-overrides' ).then( 
				
				function ( r ) {
					
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.overrides = r.data.overrides;
						$scope.selectedO = r.data.selected_overrides;
						$scope.override_info = r.data.override_info;

					}
				
				},

				function () {

					_alert( 'Failed to load override permissions.' );

				});

		};

		$scope.getOverrides();

	  $scope.toggleO = function (override, list) {
	  	$scope.dirty_overrides = true;
	    var idx = list.indexOf(override);
	    if (idx > -1) {
	      list.splice(idx, 1);
	    }
	    else {
	      list.push(override);
	    }
	  };

	  $scope.existsO = function (override, list) {
	    return list.indexOf(override) > -1;
	  };

	  $scope.isIndeterminateO = function() {
	    return ($scope.selectedO.length !== 0 &&
	        $scope.selectedO.length !== $scope.overrides.length);
	  };

	  $scope.isCheckedO = function() {
	    return $scope.selectedO.length === $scope.overrides.length;
	  };

	  $scope.toggleAllO = function() {
	  	$scope.dirty_overrides = true;
	    if ($scope.selectedO.length === $scope.overrides.length) {
	      $scope.selectedO = [];
	    } else if ($scope.selectedO.length === 0 || $scope.selectedO.length > 0) {
	      $scope.selectedO = $scope.overrides.slice(0);
	    }
	  };

	  $scope.saveOverrides = function () {

			l(1);

			$id = $scope.project_id;
			$member_id = $scope.member_id;

			$http.post( '/projects/' + $id + '/team/' + $member_id + '/save-overrides', { 'selected_overrides' : $scope.selectedO } ).then( 
				
				function ( r ) {
					
					l(0);

					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.dirty_overrides = false;
						_notifySuccess( 'Overrides updated successfully.' );

					}
				
				},

				function () {

					l(0);

					_alert( 'Failed to update overrides for this team member.' );

				});

		};

	// Checkbox functions for restrictions

		$scope.restrictions = [];
		$scope.selectedR = [];
		$scope.restriction_info = {};
	  $scope.dirty_restrictions = false;

		$scope.getRestrictions = function ( filter ) {

	  	$scope.dirty_restrictions = false;
			$id = $scope.project_id;
			$member_id = $scope.member_id;

			$http.get( '/projects/' + $id + '/team/' + $member_id + '/get-restrictions' ).then( 
				
				function ( r ) {
					
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.restrictions = r.data.restrictions;
						$scope.selectedR = r.data.selected_restrictions;
						$scope.restriction_info = r.data.restriction_info;

					}
				
				},

				function () {

					_alert( 'Failed to load restriction permissions.' );

				});

		};

		$scope.getRestrictions();

	  $scope.toggleR = function (restriction, list) {
	  	$scope.dirty_restrictions = true;
	    var idx = list.indexOf(restriction);
	    if (idx > -1) {
	      list.splice(idx, 1);
	    }
	    else {
	      list.push(restriction);
	    }
	  };

	  $scope.existsR = function (restriction, list) {
	    return list.indexOf(restriction) > -1;
	  };

	  $scope.isIndeterminateR = function() {
	    return ($scope.selectedR.length !== 0 &&
	        $scope.selectedR.length !== $scope.restrictions.length);
	  };

	  $scope.isCheckedR = function() {
	    return $scope.selectedR.length === $scope.restrictions.length;
	  };

	  $scope.toggleAllR = function() {
	  	$scope.dirty_restrictions = true;
	    if ($scope.selectedR.length === $scope.restrictions.length) {
	      $scope.selectedR = [];
	    } else if ($scope.selectedR.length === 0 || $scope.selectedR.length > 0) {
	      $scope.selectedR = $scope.restrictions.slice(0);
	    }
	  };

	  $scope.saveRestrictions = function () {

			l(1);

			$id = $scope.project_id;
			$member_id = $scope.member_id;

			$http.post( '/projects/' + $id + '/team/' + $member_id + '/save-restrictions', { 'selected_restrictions' : $scope.selectedR } ).then( 
				
				function ( r ) {
					
					l(0);

					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.dirty_restrictions = false;
						_notifySuccess( 'Restrictions updated successfully.' );

					}
				
				},

				function () {

					l(0);

					_alert( 'Failed to update restrictions for this team member.' );

				});

		};

	// Load member information
	
	$scope.member = {};

	$scope.getMember = function ( filter ) {

		l(1);

		$id = $scope.project_id;
		$member_id = $scope.member_id;

		$http.get( '/projects/' + $id + '/team/' + $member_id + '/get-member' ).then( 
			
			function ( r ) {
				
				l(0);

				if ( typeof r.data.errors != 'undefined' ) {

					_alert( r.data.errors, 1 );

				} else {
					
					$scope.member = r.data.member;

				}
			
			},

			function () {

				l(0);

				_alert( 'Failed to load team member information.' );

			});

	};

	$scope.getMember();

}]);