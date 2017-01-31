<?php $hidefull = Config::get('pageconfig') == 'full-template'; ?><!DOCTYPE html>
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

    @include('layouts.page-head')

  </head>

  <body ng-app="test" ng-cloak>

  <div layout="column">
    
    @if ( !$hidefull )

    @include('layouts.page-top')

    @endif

    <div flex>
      
      <div class="main-container theme-showcase" role="main">
      
        @if ( !$hidefull )
    
        <div layout="row">
  
          <div flex="15" class="left-side-border left-side-border-bottom page-top-left hidden-xs">

            <a href="/projects"><i class="fa fa-bars"></i> &nbsp; 

              <md-truncate flex>{{__( "All Projects" )}}</md-truncate>
              
            </a>

          </div>

          <div flex="15" class="left-side-border left-side-border-bottom page-top-left visible-xs">

            <a href="/projects"><i class="fa fa-bars"></i></a>

          </div>

          <div flex class="left-side-border-bottom page-top-right hidden-xs">
          
            <span class="page-heading">@yield('page-heading')</span>

          </div>

          <div flex class="left-side-border-bottom page-top-right visible-xs">
          
            <span class="page-heading">@yield('page-heading')</span>

          </div>

        </div>

        @endif

        @if ( $hidefull )

        <br />

        <style>
        html, body { border :none !important; }
        </style>

        @endif

        <div layout="row">

          <div flex="<?= !$hidefull ? 15 : 0; ?>">

            @yield('left-side')

          </div>

          <div flex class="main-content">

          @if( isset( $layout_toolbar ) && !$hidefull )

            @yield('toolbar')

          @endif

            @yield('main')

          </div>

          <div flex="<?= !$hidefull ? 5 : 0; ?>">

            @yield('right-side')

          </div>

        </div>


      </div> <!-- /container -->

      </div>
    </div>

    @include('layouts.page-foot')

    <div id="loading-container">
    &nbsp;
    </div>

  </body>

</html>
