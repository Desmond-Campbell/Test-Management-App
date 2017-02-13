app.controller('SearchCtrl', ['$scope', '$http', function ( $scope, $http ) {

	
}]);

var dialogScope;

app.controller('DialogCtrl', ['$scope', '$http', '$mdDialog', '$mdToast', function ( $scope, $http, $mdDialog, $mdToast ) {

	dialogScope = $scope;

	$scope.alert = function( text, type, no_translate ) {

		$title = type == 'alert' ? _tt( 'Alert' ) : _tt( 'Error' );
		$text = text;

		$mdDialog.show(
      $mdDialog.alert()
        .clickOutsideToClose(true)
        .title( $title )
        .textContent( $text )
        .ariaLabel()
        .ok( _tt( 'OK' ) )
    );

	};

	$scope.notify = function( message, type = 'info' ) {
		
		template = '<md-toast class="md-toast-' + type + '">' + _tt( message ) + '</md-toast>';

		$mdToast.show({
			scope 			: true,
			hideDelay   : 3000,
      position    : 'bottom left',
      template 		: template
    });
	}

}]);

app.controller('MainCtrl', ['$scope', '$http', '$timeout', function ( $scope, $http, $timeout ) {

	la_mode = $('#la-mode').val();

	if ( la_mode == 1 ) {

		window.onbeforeunload = function () {

			latimer();

		};

		$scope.intrvl = 7500;
		$scope.timevalue = 0;

		latimer = function () {

			$pagehash = $('#page-hash').val();
			$timevalue = TimeMe.getTimeOnCurrentPageInSeconds().toFixed(2);
			$properties = { 
											'dh' : $(document).height(), 
											'dw' : $(document).width(), 
											'wh' : $(window).height(), 
											'ww' : $(window).width(), 
											'st' : $(window).scrollTop()
										};

			if ( $timevalue != $scope.timevalue && $timevalue > 0 ) {

				$http.post( '/projects/la.js', { timevalue : $timevalue, pagehash : $pagehash, properties : $properties } ).then( function () {
					$scope.intrvl = parseInt( $scope.intrvl );
					$scope.timevalue = $timevalue;
					window.setTimeout( 'latimer()', $scope.intrvl );
				});

			} else {

				$scope.intrvl = parseInt( $scope.intrvl * 1.1 );
				window.setTimeout( 'latimer()', $scope.intrvl );

			}

		};

		latimer();

	}

}]);
