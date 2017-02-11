var app = angular.module('test',  [ 'ngMaterial', 'mdColorPicker' ]);

function _error( text, no_translate = false ) {

	_dialog( text, 'error', no_translate );

}

function _alert( text, no_translate = false ) {

	_dialog( text, 'alert', no_translate );

}

function _dialog( text, type, no_translate ) {

	dialogScope.alert( text, type, no_translate );

}

function _notify( text, no_translate ) {

	dialogScope.notify( text, 'info', no_translate );

}

function _notifyError( text, no_translate ) {

	dialogScope.notify( text, 'error', no_translate );

}

function _notifySuccess( text, no_translate ) {

	dialogScope.notify( text, 'success', no_translate );

}

function to( u ) {

  location.assign( u );

}

function _tt( text ) {

	return text;

}

function l(mode) {
	if ( mode ) {
		$('#loading-container').fadeIn('fast');
	} else {
		$('#loading-container').fadeOut('fast');
	}
}

app.filter('relativeTime', function() {

  return function(timestamp) {

    return output = moment(timestamp).fromNow();

  }

});

app.filter('shorten', function () {
    return function (value, wordwise, max, tail) {
        if (!value) return '';

        max = parseInt(max, 10);
        if (!max) return value;
        if (value.length <= max) return value;

        value = value.substr(0, max);
        if (wordwise) {
            var lastspace = value.lastIndexOf(' ');
            if (lastspace != -1) {
              //Also remove . and , so its gives a cleaner result.
              if (value.charAt(lastspace-1) == '.' || value.charAt(lastspace-1) == ',') {
                lastspace = lastspace - 1;
              }
              value = value.substr(0, lastspace);
            }
        }

        return value + (tail || ' …');
    };
});

app.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            
            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);

app.service('fileUpload', ['$http', function ($http) {
    this.uploadFileToUrl = function(file, uploadUrl){
        var fd = new FormData();
        fd.append('file', file);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined}
        })
        .success(function(){
        })
        .error(function(){
        });
    }
}]);

app.config(function ($sceProvider) {
    $sceProvider.enabled(false);
});

app.directive('onEnter',function() {

  var linkFn = function(scope,element,attrs) {
    element.bind("keypress", function(event) {
      if(event.which === 13) {
        scope.$apply(function() {
      scope.$eval(attrs.onEnter);
        });
        event.preventDefault();
      }
    });
  };

  return {
    link:linkFn
  };
});

app.directive('onEscape',function() {

  var linkFn = function(scope,element,attrs) {
    element.bind("keypress", function(event) {
      if(event.which === 27) {
        scope.$apply(function() {
      scope.$eval(attrs.onEnter);
        });
        event.preventDefault();
      }
    });
  };

  return {
    link:linkFn
  };
});

app.directive('ngFiles', ['$parse', function ($parse) {

    function fn_link(scope, element, attrs) {
        var onChange = $parse(attrs.ngFiles);
        element.on('change', function (event) {
            onChange(scope, { $files: event.target.files });
        });
    };

    return {
        link: fn_link
    }
} ]);

function receiveResult( result ){

  $('md-backdrop').hide();
  $('.md-dialog-container').hide();
  $('.md-scroll-mask').hide();

}