<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="/img/icon.png">

    <title>@yield('title') - Test</title>

    @include('layouts.page-head')
  </head>

  <body ng-app="test" ng-cloak>

  <div layout="column">
    
    @include('layouts.page-top')

    <div flex>
      
      <div class="main-container theme-showcase" role="main">
      
        <div layout="row" class="push-down">

          <div flex="20">
          </div>
          <div flex>
            @yield('main')

        @if ( isset( $result['message'] ) )

          <div class="push-down text-danger text-center">
            <small>[{{$result['message']}}]</small>
          </div>

        @endif

        @if ( isset( $result['debug'] ) && env( 'PERMISSION_DEBUG' ) )

          <div class="push-down text-danger text-center">
            <?php print_r( $result['debug'] ); ?></small>
          </div>

        @endif

          </div>
          <div flex="20">
          </div>

        </div>


      </div> <!-- /container -->

      </div>
    </div>

    @include('layouts.page-foot')

    <br /><br /><br />

  </body>
  
</html>
