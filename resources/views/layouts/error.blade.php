<?php

$bugsnapper = Config::get( 'bugsnapper_response' );

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="image" href="/favicon.png">

    <title>@yield("title") - SaasTest</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/error.css" rel="stylesheet">

  </head>

  <body>

    @if ( env( 'APP_DEBUG' ) )

    <style>
    body *, html * {background: #110000 !important; color: #FFF}
    </style>

    <div style="width:80%; margin:auto; margin-top: 25px">

      <h1>{{arg( $bugsnapper, 'class', 'Error' )}}</h1>
      <div class="panel">
        <div class="panel-title">
            {{arg( $bugsnapper, 'description', 'An error has occured.' )}}
        </div>
        <div class="panel-body" style="font-size: 80%">
          {{nl2br( arg( $bugsnapper, 'string' ) )}}
        </div>
      </div>

    </div>

    @else

    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills float-right">
            <li class="nav-item">
              <a class="nav-link" href="http://{{env('APP_DOMAIN')}}/">{{___("Home")}}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://www.{{env('APP_DOMAIN')}}/contact">{{___("Contact Us")}}</a>
            </li>
          </ul>
        </nav>
        <h3 class="text-muted">SaasTest</h3>
      </div>

      <div class="jumbotron">
        <h1 class="text-red">@yield("title")</h1>
        <p class="lead">@yield("message"):</p>

        <h3>{{___("Reference")}} #{{arg( $bugsnapper, 'reference_number', '999' )}}</h3>
      </div>

      <footer class="footer">
        <p>&copy; SaasTest {{date("Y")}}</p>
      </footer>

    </div> 

    @endif

  </body>
</html>
