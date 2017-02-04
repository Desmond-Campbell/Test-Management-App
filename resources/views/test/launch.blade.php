@extends('index-full')

@section('title')
{{ $test->name }} {{$project->title}}
@stop

@section('main')

    <div class="main-content" ng-controller="ProjectTestLaunchCtrl">

      <input type="hidden" id="project_id" value="{{$project->id}}" />
      <input type="hidden" id="test_id" value="{{$test->id}}" />

      <div class="heading-cell">
        <h2>{{$test->name}} - {{$project->title}}</h2>
      </div>

      <br />

      <md-tabs md-border-bottom md-dynamic-height>

        <md-tab label="{{___( "Activity" )}}">
        
          <div class="md-padding">

            <div ng-show="!(activity.id > 0)">
              <h3>{{___( "No more activities left to test." )}}</h3>
              <p>{{___( "Check test cases tab to view steps that you may have skipped." )}}</p>
            </div>

            <div layout="row" class="push-down" ng-show="activity.id > 0">

              <div flex>

                <h4 class="bold">@{{scenario.name}}</h4>
                <h5>@{{case.name}}</h5>

              <md-card class="no-margin-left push-down alert alert-info-inverse no-borders test-step-info">

                  <big><big>@{{step.name}}</big></big>
                
                </md-card>

                <button class="btn btn-success" ng-click="passTest()">{{ ___( "Pass" ) }}</button> &nbsp;
                <button class="btn btn-danger" ng-click="failTest()">{{ ___( "Fail" ) }}</button> &nbsp;
                <button class="btn btn-warning" ng-click="skipStep()">{{ ___( "Skip" ) }}</button> &nbsp;

              </div>

              <div flex="5"></div>

              <div flex="25">

                <div class="side-margins light-success-bg bold-top-border" layout-padding>
                  <h4 class="no-margins">{{___( "Pass Criteria" )}}</h4>
                  <div class="smaller-text" ng-show="case.pass_criteria == null">
                    {{__( "N/A" )}}
                  </div>
                  <div class="smaller-text" ng-show="case.pass_criteria != null">
                    @{{case.pass_criteria}}
                  </div>
                </div>

              </div>

              <div flex="25">

                <div class="side-margins light-danger-bg bold-top-border" layout-padding>
                  <h4 class="no-margins">{{___( "Fail Criteria" )}}</h4>
                  <div class="smaller-text" ng-show="case.fail_criteria == null">
                    {{__( "N/A" )}}
                  </div>
                  <div class="smaller-text" ng-show="case.fail_criteria != null">
                    @{{case.fail_criteria}}
                  </div>
                </div>

              </div>

            </div>

          </div>

        </md-tab>

        <md-tab label="{{___( "Results" )}}">
        
          <div class="md-padding push-down">

          </div>

        </md-tab>

        <md-tab label="{{___( "Issues" )}}">
        
          <div class="md-padding push-down">

          </div>

        </md-tab>

        <md-tab label="{{___( "Test Cases" )}}">
        
          <div class="md-padding push-down">

          </div>

        </md-tab>

        <md-tab label="{{___( "Resources" )}}">
        
          <div class="md-padding push-down">

          </div>

        </md-tab>

      </md-tabs>
      

    </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/ProjectTestLaunchCtrl.js"></script>
@stop
