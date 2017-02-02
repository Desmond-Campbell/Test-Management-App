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

  <div ng-controller="ProjectSuitesEditCaseCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    <input type="hidden" id="suite_id" value="{{$suite->id}}" />
    <input type="hidden" id="case_id" value="{{$case->id}}" />
    <input type="hidden" id="pageconfig" value="{{Config::get('pageconfig')}}" />
    
    <h1 class="no-margin-top">{{___( "Edit Test Case" )}}</h1>

    <br />

    @if ( Config::get('pageconfig') == 'full-template' )
    <div class="alert alert-info-inverse md-container">
      <strong>{{___( 'Need a larger screen to configure this test case?' )}}</strong> <a href="/projects/{{$project->id}}/suites/{{$suite->id}}/edit-case/{{$case->id}}" target="_top">{{___( "Here you go" )}} <i class="fa fa-long-arrow-right"></i></a>
    </div>
    @endif

      <md-tabs md-border-bottom md-dynamic-height>
        <md-tab label="{{___( "Properties" )}}">
          <div class="md-padding push-down">
      
      <form class="form @if ( Config::get('pageconfig') != 'full-template' ) slim-form @endif" role="form" method="post" action="" onsubmit="return false">

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

          <br />

          <button type="submit" class="btn btn-success" ng-click="save()">{{__( "Save" )}}</button> 
          <button type="reset" class="btn btn-danger" ng-click="cancel()">{{__( "Cancel" )}}</button> 

        </form>

        </md-tab>
        <md-tab label="{{___( "Steps" )}}">
          <div class="md-padding push-down">

            <div ng-repeat="s in steps" ng-class="getStepClass($index)" layout-padding layout="row">

              <div flex="5" class="number-column">
              @{{$index+1}}
              </div>

              <div flex>

                <div ng-click="editStep($index)" class="no-outlines">
                  <span ng-show="!checkIndex($index)">@{{s.name}}</span>
                  <span ng-show="checkIndex($index)">
                    <md-input-container class="md-block">
                      <input ng-model="s.name" aria-label="." class="step-editor" on-enter="saveSteps(); cancelEditStep()" />
                    </md-input-container>
                  </span>
                </div>

                <div ng-show="checkIndex($index)" class="pull-up">
                  <md-button class="" aria-label="." ng-click="cancelEditStep()"><i class="fa fa-check"></i></md-button>
                  <md-button class="" aria-label="." ng-click="deleteStep($index)"><i class="fa fa-trash"></i></md-button>
                  <md-button class="" aria-label="." ng-show="$index > 0" ng-click="moveUpStep($index)"><i class="fa fa-arrow-up"></i></md-button>
                  <md-button class="" aria-label="." ng-show="$index < ( steps.length - 1 )" ng-click="moveDownStep($index)"><i class="fa fa-arrow-down"></i></md-button>
                  <md-button class="" aria-label="." ng-click="copyStep($index)"><i class="fa fa-copy"></i></md-button>
                  <md-button class="" aria-label="." ng-click="resetStep($index)"><i class="fa fa-times"></i></md-button>

                </div>

              </div>

            </div>

            <br />

            <md-input-container class="md-block">
              <input ng-model="newstep" placeholder="{{___( "Enter a new step here..." )}}" ng-blur="addStep()" on-enter="addStep()" /> <br />
                <button class="btn btn-success btn-sm" ng-click="addStep()"><i class="fa fa-check"></i></button> &nbsp; 
                <button class="btn btn-warning btn-sm" ng-click="cancelAddStep()"><i class="fa fa-times"></i></button>
            </md-input-container>
            
          </div>
        </md-tab>
        <md-tab label="{{___( "Criteria" )}}">
          <div class="md-padding push-down">
            
          </div>
        </md-tab>
        {{--<md-tab label="{{___( "Past Results" )}}">
          <div class="md-padding push-down">
            
          </div>
        </md-tab>--}}
      </md-tabs>

  </div>
@stop

@section('javascript')
  <script src="/js/controllers/ProjectSuitesEditCaseCtrl.js"></script>
@stop
