@extends('index-full')

@section('title')
{{ $test->name }} {{$project->title}}
@stop

@section('main')

    <div class="main-content" ng-controller="ProjectBatchResultsCtrl">

      <input type="hidden" id="project_id" value="{{$project->id}}" />
      <input type="hidden" id="test_id" value="{{$test->id}}" />
      <input type="hidden" id="batch_id" value="{{$batch_id}}" />

      <div class="heading-cell">
        <h2>{{$test->name}} - {{$project->title}}</h2>
      </div>

      <br />

      <div class="push-down">

        <button class="btn btn-default" ng-click="getResults()">{{___( "Update Results" )}}</button>

        <div class="push-down" ng-show="results.length > 0">

          <div ng-repeat="r in results">

            <md-card class="no-margin-left">
            
              <div class="panel-heading">@{{r.case.name}}</div>

              <div class="panel-body">
                
                <table class="table">

                  <tr ng-repeat="s in r.data">
                    <td width="60%">
                      <i class="fa fa-check result-type-result" ng-show="s.result_type == 'result'"><md-tooltip md-direction="bottom">{{___( "Passed the most recent test." )}}</md-tooltip></i> 
                      <i class="fa fa-square-o" ng-show="s.result_type != 'result' && s.result_type != 'issue'"><md-tooltip md-direction="bottom">{{___( "No test results available.." )}}</md-tooltip></i> 
                      <i class="fa fa-times result-type-issue" ng-show="s.result_type == 'issue'"><md-tooltip md-direction="bottom">{{___( "Failed the most recent test." )}}</md-tooltip></i> &nbsp;
                      @{{s.step.name}}
                    </td>
                    <td align="right">
                      <span ng-repeat="i in s.results">
                        <a href="javascript:;" ng-click="showResult(s.id, $index)">
                          <span ng-show="i.type == 'result'" class="label label-success">
                            <i class="fa fa-check"></i>
                            <md-tooltip md-direction="bottom">{{___( "PASSED" )}} - @{{i.title}} - {{___( "submitted" )}} @{{i.created_at | relativeTime}} {{___( "by" )}} @{{i.user_name}}</md-tooltip>
                          </span>
                          <span ng-show="i.type != 'result'" class="label label-danger">
                            <i class="fa fa-times"></i>
                            <md-tooltip md-direction="bottom">{{___( "FAILED" )}} - @{{i.title}} - {{___( "submitted" )}} @{{i.created_at | relativeTime}} {{___( "by" )}} @{{i.user_name}}</md-tooltip>
                          </span>
                        </a>&nbsp;
                      </span>
                    </td>
                  </tr>

                </table>

              </div>

            </md-card>

          </div>

        </div>

      </div>

    </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/ProjectBatchResultsCtrl.js"></script>
@stop
