
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="image" href="/favicon.png">

    <title>{{___("Auto Log In")}} - SaasTest</title>

    <link href="/css/error.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link href="/css/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/css/vendor/bootstrap/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link rel="stylesheet" href="/js/vendor/node_modules/angular-material/angular-material.css">

    <!-- Custom styles for this template -->
    <link href="/css/custom.css" rel="stylesheet">
    <link href="/css/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/js/vendor/bootstrap/ie-emulation-modes-warning.js"></script>

  </head>

  <body>

<div class="header clearfix">
  <nav class="navbar navbar-default navbar-inverse">

    <div class="navbar-header">

        <!-- Collapsed Hamburger -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <!-- Branding Image -->
        <a class="navbar-brand" href="http://www.saastest.cm">
            <img src="/img/st-slogan.png" style="height: 24px; margin-top: -2px !important" />
        </a>
    </div>

    <ul class="nav navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="http://{{env('APP_DOMAIN')}}/">{{___("Home")}}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://my.{{env('APP_DOMAIN')}}/login">{{___("Log In")}}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="http://{{env('APP_DOMAIN')}}/contact">{{___("Contact Us")}}</a>
      </li>
    </ul>
  </nav>
</div>

  <div>

    <div style="width: 60%; margin:auto">

      <div>
        <h1 class="display-3">{{___("Auto Log In")}}</h1>
        <p>{{___("You're about to enter our demo environment. We will log you in with one of the following accounts. Please note that this will clear any current logged in session to a real network.")}}</p>

      </div>

      <h3>{{___("Please choose the account you wish to log in with.")}}</h3><br />

      <div>

        <div class="light-bg padding-10">

          <table class="table">

            <tr>
              <th width="20%">{{___("Account Name")}}</th>
              <th>{{___("Permissions")}}</th>
              <th width="10%">&nbsp;</th>
            </tr>

            <tr>
              <td>{{___("1. Vladimir (Network Owner)")}}</td>
              <td><strong>{{___("Network Owner")}}</strong><br /><small>{{___("This user can do everything possible in a network, on projects, with teams, etc. He's the super administrator guy.") }}</small></td>
              <td><a href="/network/autologin/1" class="btn btn-primary btn-sm" style="color: #FFF !important">{{___("Use This")}}</a></td>
            </tr>

            <tr>
              <td>{{___("2. Justin (Admin)")}}</td>
              <td><strong>{{___("Administrator")}}</strong><br /><small>{{___("This user can perform most actions that the super administrator (Vladimir Polocheck) can perform. He's just not a network owner.") }}</small></td>
              <td><a href="/network/autologin/2" class="btn btn-primary btn-sm" style="color: #FFF !important">{{___("Use This")}}</a></td>
            </tr> 

            <tr>
              <td>{{___("3. Dimitri (Project Admininistrator)")}}</td>
              <td><strong>{{___("Project Admin")}}</strong><br /><small>{{___("This user can perform most actions related to projects and members throughout the network, but can't manage the network itself.") }}</small></td>
              <td><a href="/network/autologin/3" class="btn btn-primary btn-sm" style="color: #FFF !important">{{___("Use This")}}</a></td>
            </tr>

            <tr>
              <td>{{___("4. Nadine (Project Manager)")}}</td>
              <td><strong>{{___("Singular Project Admin")}}</strong><br /><small>{{___("This user can perform most actions related to projects that they have created only.") }}</small></td>
              <td><a href="/network/autologin/4" class="btn btn-primary btn-sm" style="color: #FFF !important">{{___("Use This")}}</a></td>
            </tr>

            <tr>
              <td>{{___("5. Gladys (Tester)")}}</td>
              <td><strong>{{___("Tester")}}</strong><br /><small>{{___("This user can only execute tests.") }}</small></td>
              <td><a href="/network/autologin/5" class="btn btn-primary btn-sm" style="color: #FFF !important">{{___("Use This")}}</a></td>
            </tr>     

          </table>

        </div>

        <div class="push-down">
          <h3>{{___("Additional Information")}}</h3>
          <p>{{___("While you're in the demo, please note the following:")}}</p>
          <ul>
            <li>{{___("You can't access or modify details for these accounts.")}}</li>
            <li>{{___("You can't access or modify details of the network.")}}</li>
            <li>{{___("You can't create additional people in the network.")}}</li>
            <li>{{___("You can't add or remove people to/from a project.")}}</li>
            <li>{{___("You can't change permissions for people in a project.")}}</li>
          </ul>
          <h4>{{___("Why?")}}</h4>
          <p>{{___("We are trying to make this environment suitable for proper demonstration of the benefits of SaasTest. Therefore, we decided to control some of the permissions so that at any point in time, anyone who participates in a demo will be able to benefit from the configurations.")}}</p>
          <p><strong>{{___("NB: The data in our demo network resets every few hours.")}}</strong></p>
        </div>

      </div>

      <footer class="footer">
        <p>&copy; SaasTest {{date("Y")}}</p>
      </footer>

    </div> 

  </div>

  <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="/js/vendor/jquery-2.2.1.min.js"><\/script>')</script>
    <script src="/js/vendor/node_modules/angular/angular.js"></script> 
    <script src="/js/vendor/node_modules/angular-aria/angular-aria.js"></script> 
    <script src="/js/vendor/node_modules/angular-animate/angular-animate.js"></script> 
    <script src="/js/vendor/node_modules/angular-material/angular-material.js"></script>
    <script src="/js/vendor/tinycolor-min.js"></script>
    <script src="/js/vendor/md-color-picker/mdColorPicker.js"></script>

    <script src="/js/app.js"></script>
        <script src="/js/controllers/Controller.js"></script>
    <script src="/js/vendor/moment.js"></script>
    <script src="/js/vendor/angular-moment.js"></script>
    <script src="/js/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="/js/vendor/bootstrap/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/vendor/bootstrap/ie10-viewport-bug-workaround.js"></script>
    <br /><br /><br />

  </body>
</html>
