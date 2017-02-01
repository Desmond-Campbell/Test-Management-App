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

  <div ng-controller="ProjectSuitesEditCaseCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    <input type="hidden" id="suite_id" value="{{$suite->id}}" />
    <input type="hidden" id="case_id" value="{{$case->id}}" />
    <input type="hidden" id="pageconfig" value="{{Config::get('pageconfig')}}" />
    
    <h1 class="no-margin-top">{{___( "Edit Test Case" )}}</h1>

    <br />

    @if ( Config::get('pageconfig') != 'full-template' )
    <div class="alert alert-info-light md-container">
      {{___( 'A test case is an actual test for a test condition or scenario.' )}}
    </div>
    @else
    <div class="alert alert-info-inverse md-container">
      <strong>{{___( 'Need a larger screen to configure this test case?' )}}</strong> <a href="/projects/{{$project->id}}/suites/{{$suite->id}}/edit-case/{{$case->id}}" target="_top">{{___( "Here you go" )}} <i class="fa fa-long-arrow-right"></i></a>
    </div>
    @endif

    <form class="form slim-form" role="form" method="post" action="" onsubmit="return false">

      <md-tabs md-border-bottom md-dynamic-height>
        <md-tab label="{{___( "Properties" )}}">
          <div class="md-padding push-down">
            
            <div layout-gt-xs="row">

              <md-input-container flex-gt-xs>

                <label>{{__( "Test Case Name" )}}</label>
                <input class="md-block input-lg md-no-underline" 
                      id="case-name"
                      maxlength="50" 
                      ng-model="case.name" />

              </md-input-container>

            </div>

            <div layout-gt-xs="row">

              <md-input-container flex-gt-xs>

                <label>{{__( "Short Description" )}}</label>
                <input class="md-block input-lg md-no-underline" 
                      id="case-description"
                      maxlength="72" 
                      ng-model="case.description" />

              </md-input-container>

            </div>

          </div>
        </md-tab>
        <md-tab label="{{___( "Test Steps" )}}">
          <div class="md-padding push-down">

            <div ng-repeat="s in steps" class="push-down no-outlines" layout-padding layout="row">

              <div ng-click="editStep($index)" flex>
               <span ng-show="!checkIndex($index)">@{{s.name}}</span>
               <span ng-show="checkIndex($index)"><textarea ng-model="s.name"></textarea> </span>
              </div>

              <div flex="15">
                <button class="btn btn-success" ng-show="checkIndex($index)" ng-click="cancelEditStep()"><i class="fa fa-check"></i></button> &nbsp; 
                <button class="btn btn-default" ng-show="checkIndex($index) && $index > 0" ng-click="moveUpStep($index)"><i class="fa fa-arrow-up"></i></button> &nbsp; 
                <button class="btn btn-default" ng-show="checkIndex($index) && $index < ( steps.length - 1 )" ng-click="moveDownStep($index)"><i class="fa fa-arrow-down"></i></button> &nbsp; 
                <button class="btn btn-primary" ng-show="checkIndex($index)" ng-click="copyStep($index)"><i class="fa fa-copy"></i></button> &nbsp; 
                <button class="btn btn-danger" ng-show="checkIndex($index)" ng-click="resetStep($index)"><i class="fa fa-times"></i></button>

              </div>

            </div>

            <br />

            <textarea ng-model="newstep" ng-blur="addStep()" onEnter="addStep(); return false"></textarea>
            
          </div>
        </md-tab>
        <md-tab label="{{___( "Past Results" )}}">
          <div class="md-padding push-down">
            
          </div>
        </md-tab>
      </md-tabs>


        <button type="submit" class="btn btn-success" ng-click="save()">{{__( "Save" )}}</button> 
        <button type="reset" class="btn btn-danger" ng-click="cancel()">{{__( "Cancel" )}}</button> 

      </form>

  </div>
@stop

@section('javascript')
  <script src="/js/controllers/ProjectSuitesEditCaseCtrl.js"></script>
@stop
