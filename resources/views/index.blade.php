<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>@yield('title') - Test</title>

    <!-- Bootstrap core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link href="/css/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/css/vendor/bootstrap/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link rel="stylesheet" href="/js/vendor/node_modules/angular-material/angular-material.css">

    <!-- Custom styles for this template -->
    <link href="/c\ss/app.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
    <link href="/css/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/vendor/bootstrap/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body ng-app="test" ng-cloak>

  <div layout="column">
    <div flex>
      
      <!-- Fixed navbar -->
      <nav class="navbar navbar-inverse n/avbar-fixed-top">
        <div class="c/ontainer">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Test</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="/projects">Projects</a></li>
              <li><a href="/plans">Test Plans</a></li>
              <li><a href="/users">Users</a></li>
              <li><a href="/settings">Settings</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>

    </div>
    <div flex>
      
      <div class="main-container theme-showcase" role="main">

      
        <div class="">

        @yield('content')

        </div>


      </div> <!-- /container -->

      </div>
    </div>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/js/vendor/bootstrap/vendor/jquery-2.2.1.min.js"><\/script>')</script>
    <script src="/js/vendor/node_modules/angular/angular.js"></script> 
    <script src="/js/vendor/node_modules/angular-aria/angular-aria.js"></script> 
    <script src="/js/vendor/node_modules/angular-animate/angular-animate.js"></script> 
    <script src="/js/vendor/node_modules/angular-material/angular-material.js"></script>

    <script src="/js/app.js"></script>
    @yield('javascript')
    <script src="/js/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="/js/vendor/bootstrap/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/vendor/bootstrap/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
