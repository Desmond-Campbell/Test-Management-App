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
      <li><a href="/projects/{{$project->id}}/suites"><img src="/img/toolbar/view.png" class="toolbar-icon" /> {{___( "View Suites" )}}</a></li>
    </ul>
  </div>
@stop

@section('main')

  <div ng-controller="ProjectSuitesEditCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    <input type="hidden" id="suite_id" value="{{$suite->id}}" />
    
    <h1 class="no-margin-top">{{___( "Edit Test Suite" )}}</h1>

    </br />

    <form class="form slim-form" role="form" method="post" action="" onsubmit="return false">

        <div layout-gt-xs="row">

          <md-input-container flex-gt-xs>

            <label>{{__( "Suite Name" )}}</label>
            <input class="md-block input-lg md-no-underline" 
                  id="suite-name"
                  maxlength="50" 
                  ng-model="suite.name" />

          </md-input-container>

        </div>

        <div layout-gt-xs="row">

          <md-input-container flex-gt-xs>

            <label>{{__( "Short Description" )}}</label>
            <input class="md-block input-lg md-no-underline" 
                  id="suite-description"
                  maxlength="72" 
                  ng-model="suite.description" />

          </md-input-container>

        </div>

        @if ( pass( 'suites.copy_suite', $project->id ) )

        <div class="text-info md-block" ng-show="suites.length > 0">
          {{___( "You can copy scenarios and cases from an existing suite into this new one. Just select it from the list below." )}}
        </div>

        <div layout-gt-xs="row" ng-show="suites.length > 0">

          <md-input-container flex-gt-xs>

            <md-select ng-model="suite.copy" placeholder="{{___( "Select an existing suite") }}" class="md-block md-no-underline">
              <md-option ng-repeat="s in suites" value="@{{s}}">@{{s}}</md-option>
            </md-select>

          </md-input-container>

        </div>

        @endif

        <button type="submit" class="btn btn-success" ng-click="save()">{{__( "Save" )}}</button> 
&nbsp;    <button type="button" class="btn btn-danger" ng-click="deleteSuite()">{{__( "Delete" )}}</button>

      </form>

  </div>
@stop

@section('javascript')
  <script src="/js/controllers/ProjectSuitesEditCtrl.js"></script>
@stop
