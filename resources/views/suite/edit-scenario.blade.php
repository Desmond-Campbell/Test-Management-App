@extends('index')

@section('title')
{{$project->title}} - {{___( "Test Suites" )}}
@stop

@section('left-side')

  @include('navs.project-manage', [ 'active' => 'suites', 'project_id' => $project->id ])

@stop

@section('page-heading')
{{___( "Test Suites" )}}
@stop

<?php $layout_toolbar = 1; ?>

@section('toolbar')
  <div id="header-toolbar">
    <ul class="toolbar">
      <li><a href="/projects/{{$project->id}}/suites{{$suite_params}}"><img src="/img/toolbar/view.png" class="toolbar-icon" /> {{___( "View Suites" )}}</a></li>
    </ul>
  </div>
@stop

@section('main')

  <div ng-controller="ProjectSuitesEditScenarioCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    <input type="hidden" id="suite_id" value="{{$suite->id}}" />
    <input type="hidden" id="scenario_id" value="{{$scenario->id}}" />
    <input type="hidden" id="pageconfig" value="{{Config::get('pageconfig')}}" />
    
    <h1 class="no-margin-top">{{___( "Edit Test Scenario" )}}</h1>

    <br />

    @if ( Config::get('pageconfig') == 'full-template' )
    <div class="alert alert-info-inverse md-container">
      <strong>{{___( 'Need a larger screen to configure this test scenario?' )}}</strong> <a href="/projects/{{$project->id}}/suites/{{$suite->id}}/edit-scenario/{{$scenario->id}}" target="_top">{{___( "Here you go" )}} <i class="fa fa-long-arrow-right"></i></a>
    </div>
    @endif

      <md-tabs md-border-bottom md-dynamic-height>
        <md-tab label="{{___( "Properties" )}}">
          <div class="md-padding push-down">
      
      <form class="form @if ( Config::get('pageconfig') != 'full-template' ) slim-form @endif" role="form" method="post" action="" onsubmit="return false">

            <div layout-gt-xs="row">

              <md-input-container flex-gt-xs>

                <label>{{__( "Scenario Name" )}}</label>
                <input class="md-block input-lg md-no-underline" 
                      id="scenario-name"
                      maxlength="50" 
                      ng-model="scenario.name" />

              </md-input-container>

            </div>

            <div layout-gt-xs="row">

              <md-input-container flex-gt-xs>

                <label>{{__( "Description" )}}</label>
                <input class="md-block input-lg md-no-underline" 
                      id="scenario-description"
                      maxlength="72" 
                      ng-model="scenario.description" />

              </md-input-container>

            </div>

          </div>

          <br />

          <button type="submit" class="btn btn-success" ng-click="save()">{{__( "Save" )}}</button> 
          <button type="reset" class="btn btn-danger" ng-click="cancel()">{{__( "Cancel" )}}</button> 

        </form>

        </md-tab>
        <md-tab label="{{___( "Files" )}}">
          <div class="md-padding push-down">

            
            
          </div>
        </md-tab>
        
      </md-tabs>

  </div>
@stop

@section('javascript')
  <script src="/js/controllers/ProjectSuitesEditScenarioCtrl.js"></script>
@stop
