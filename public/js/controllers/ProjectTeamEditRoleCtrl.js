app.controller('ProjectTeamEditRoleCtrl', ['$scope', '$http', '$mdDialog', '$timeout', function ( $scope, $http, $mdDialog, $timeout ) {

	$scope.project_id = $( '#project_id').val();
	$scope.role_id = $( '#role_id').val();
	$scope.selected = [];
	$scope.perms = [];

	// Load role information
	
		$scope.role = {};

		$scope.getRole = function ( filter ) {

			l(1);

			$id = $scope.project_id;
			$role_id = $scope.role_id;

			$http.get( '/projects/' + $id + '/team/' + $role_id + '/get-role' ).then( 
				
				function ( r ) {
					
					l(0);

					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.role = r.data.role;

					}
				
				},

				function () {

					l(0);

					_alert( 'Failed to load role information.' );

				});

		};

		$scope.getRole();

		$scope.saveRole = function () {

			$id = $scope.project_id;
			$role_id = $scope.role_id;

			$http.post( '/projects/' + $id + '/team/' + $role_id + '/save-role', $scope.role ).then( 
				
				function ( r ) {
					
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					}
				
				},

				function () {

					_alert( 'Failed to update information for this role.' );

				});

		};

		$scope.getPerms = function () {

	  	$scope.dirty_perms = false;
			$id = $scope.project_id;
			$role_id = $scope.role_id;

			$http.get( '/projects/' + $id + '/team/' + $role_id + '/get-permissions' ).then( 
				
				function ( r ) {
					
					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.perms = r.data.perms;
						$scope.selected = r.data.selected_perms;
						$scope.perm_info = r.data.perm_info;

					}
				
				},

				function () {

					_alert( 'Failed to load permissions for this role.' );

				});

		};

		$scope.getPerms();

	// Checkbox functions for perms		

		$scope.selected = [];
		$scope.perm_info = {};
	  $scope.dirty_perms = false;

		$scope.toggle = function (perm, list) {
	  	$scope.dirty_perms = true;
	    var idx = list.indexOf(perm);
	    if (idx > -1) {
	      list.splice(idx, 1);
	    }
	    else {
	      list.push(perm);
	    }
	  };

	  $scope.exists = function (perm, list) {
	    return list.indexOf(perm) > -1;
	  };

	  $scope.isIndeterminate = function() {
	    return ($scope.selected.length !== 0 &&
	        $scope.selected.length !== $scope.perms.length);
	  };

	  $scope.isChecked = function() {
	    return $scope.selected.length === $scope.perms.length;
	  };

	  $scope.toggleAll = function() {
	  	$scope.dirty_perms = true;
	    if ($scope.selected.length === $scope.perms.length) {
	      $scope.selected = [];
	    } else if ($scope.selected.length === 0 || $scope.selected.length > 0) {
	      $scope.selected = $scope.perms.slice(0);
	    }
	  };

	  $scope.savePerms = function () {

			l(1);

			$id = $scope.project_id;
			$role_id = $scope.role_id;

			$http.post( '/projects/' + $id + '/team/' + $role_id + '/save-permissions', { 'selected_perms' : $scope.selected } ).then( 
				
				function ( r ) {
					
					l(0);

					if ( typeof r.data.errors != 'undefined' ) {

						_alert( r.data.errors, 1 );

					} else {
						
						$scope.dirty_perms = false;
						_notifySuccess( 'Permissions updated successfully.' );

					}
				
				},

				function () {

					l(0);

					_alert( 'Failed to update permissions for this role.' );

				});

		};

}]);