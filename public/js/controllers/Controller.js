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
