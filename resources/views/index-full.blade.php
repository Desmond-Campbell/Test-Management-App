<?php $hidefull = Config::get('pageconfig') == 'full-template'; ?><!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title') - Test</title>

    @include('layouts.page-head')
  </head>

  <body ng-app="test" ng-cloak>

  <div layout="column">
    
    @if ( !$hidefull )

    @include('layouts.page-top')

    @endif

    <div flex>
      
      <div class="main-container theme-showcase" role="main">
      
        <div layout="row" class="">

          @if ( !$hidefull )
          <div flex="15" class="hidden-xs">
          </div>
          @endif
          <div flex>
            @yield('main')
          </div>
          @if ( !$hidefull )
          <div flex="15" class="hidden-xs">
          </div>
          @endif

        </div>


      </div> <!-- /container -->

      </div>
    </div>

    @include('layouts.page-foot')

    <br /><br /><br />

  </body>
  
</html>
