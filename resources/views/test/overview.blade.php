@extends('index')

@section('title')
{{$project->title}} - {{___( "Test Runs" )}}
@stop

@section('left-side')

  @include('navs.project-manage', [ 'active' => 'tests', 'project_id' => $project->id ])

@stop

@section('page-heading')
{{___( "Test Runs" )}}
@stop

<?php $layout_toolbar = 1; ?>

@section('toolbar')
  <div id="header-toolbar">
    <ul class="toolbar">
      <li><a href="/projects/{{$project->id}}/tests/new"><img src="/img/toolbar/new.png" class="toolbar-icon" /> {{___( "New Test" )}}</a></li>
    </ul>
  </div>
@stop

@section('main')

  <div ng-controller="TestOverviewCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    <input type="hidden" id="test_id" value="{{$test_id}}" />

    <md-tabs md-border-bottom md-dynamic-height>
        
      <md-tab label="{{___( "Properties" )}}">
        
        <div class="md-padding push-down">

          <form class="form @if ( Config::get('pageconfig') != 'full-template' ) slim-form @endif" role="form" method="post" action="" onsubmit="return false">

            <div layout-gt-xs="row">

              <md-input-container flex-gt-xs>

                <label>{{__( "Title" )}}</label>
                <input class="md-block input-lg md-no-underline" 
                      id="test-name"
                      maxlength="50" 
                      ng-model="test.name" />

              </md-input-container>

            </div>

            <div layout-gt-xs="row">

              <md-input-container flex-gt-xs>

                <label>{{__( "Description" )}}</label>
                <input class="md-block input-lg md-no-underline" 
                      id="test-description"
                      maxlength="72" 
                      ng-model="test.description" />

              </md-input-container>

            </div>

            <br />

            <button type="submit" class="btn btn-success" ng-click="save()">{{__( "Save" )}}</button> 
            <button type="reset" class="btn btn-danger" ng-click="cancel()">{{__( "Cancel" )}}</button> 

          </form>

        </div>

      </md-tab>

      <md-tab label="{{___( "Test Cases" )}}">
        
        <div class="md-padding push-down">

          <div layout="row" ng-show="suites.length > 0">

            <div flex="30" id="suite-list">

              <div class="suite-list suites" ng-show="suites.length > 0">
                
                <h5>{{___( "Suites" )}}</h5>

                <div class="list-inner">
                  <md-card ng-repeat="S in suites" ng-class="suiteClass(S.id)"><md-checkbox 
                    ng-checked="hasSuiteWith(S.id)"
                    ng-click="toggleSuiteSelection(S.id)"
                    class="pull-left" aria-label="[]"></md-checkbox><span class="card-title" ng-click="getSuite(S.id)">@{{S.name}} (@{{S.children}})</span></md-card>
                </div>
              
              </div>

            </div>

            <div flex="30" id="scenario-list">

              <div class="suite-list scenarios">

                <div>
                  <h5>{{___( "Scenarios" )}}</h5>
                </div>
              
                <div class="list-inner">
                  <md-card ng-repeat="s in scenarios" ng-class="scenarioClass(s.id)"><md-checkbox 
                    ng-checked="hasScenarioWith(s.id)"
                    ng-click="toggleScenarioSelection(s.id, 0)"
                    class="pull-left" aria-label="[]"></md-checkbox><span class="card-title" ng-click="getScenario(s.id)">@{{s.name}} (@{{s.children}})</span></md-card>
                </div>

              </div>

            </div>

            <div flex id="case-list">

              <div class="suite-list suites" ng-show="suites.length > 0">
              
                <div>
                  <h5>{{___( "Cases" )}}</h5>
                </div>

                <div class="list-inner">
                  <md-card ng-repeat="c in cases" ng-class="caseClass(c.id)"><md-checkbox 
                    ng-checked="hasCaseWith(c.id)"
                    ng-click="toggleCaseSelection(c.id, 0)"
                    class="pull-left" aria-label="[]"></md-checkbox><span class="card-title">@{{c.name}}</span></md-card>
                </div>

              </div>

            </div>

          </div>

        </div>

      </md-tab>

      <md-tab label="{{___( "Schedule" )}}">
        
        <div class="md-padding push-down">

        </div>

      </md-tab>

      <md-tab label="{{___( "Testers" )}}">
        
        <div class="md-padding push-down">

          <md-list>
            <md-list-item ng-repeat="t in testers">
              <md-checkbox 
                    ng-checked="hasTesterWith(t.id)"
                    ng-click="toggleCaseSelection(c.id, 0)"
                    class="pull-left" aria-label="[]"></md-checkbox> @{{t.name}}
            </md-list-item>
          </md-list>

        </div>

      </md-tab>

  </div>

@stop

@section('javascript')
  <script src="/js/controllers/TestOverviewCtrl.js"></script>
@stop
