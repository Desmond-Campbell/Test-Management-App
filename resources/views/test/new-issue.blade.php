@extends('index-full')

@section('title')
{{ $test->name }} {{$project->title}}
@stop

@section('main')

    <div class="main-content container" ng-controller="ProjectCreateIssueCtrl">

      <input type="hidden" id="project_id" value="{{$project->id}}" />
      <input type="hidden" id="test_id" value="{{$test->id}}" />
      <input type="hidden" id="activity_id" value="{{$activity->id}}" />
      <input type="hidden" id="step_id" value="{{$step->id}}" />
      <input type="hidden" id="batch_id" value="{{$batch_id}}" />

      <div class="heading-cell">
        <h2>{{___( "New Issue" )}}</h2>
        <h5>{{$test->name}} - {{$project->title}}</h5>
        <a href="/projects/{{$project->id}}/tests/{{$test->id}}/activity/{{$activity->id}}/step/{{$step->id}}/new-issue" target="_blank">{{___( "Launch in new tab" )}} <i class="fa fa-long-arrow-right"></i></a>
      </div>

      <div class="alert alert-info push-down">
        <strong>{{___( "Test Step" ) }}:</strong><br />
        {{$step->name}}
      </div>

      <br />

      <form class="form" role="form" method="post" action="" onsubmit="return false">

        <div layout-gt-xs="row">

          <md-input-container flex-gt-xs>

            <label>{{__( "Title" )}}</label>
            <input class="md-block input-lg md-no-underline" 
                  id="issue-title"
                  maxlength="50" 
                  ng-model="issue.title" />

          </md-input-container>

        </div>

        <div layout-gt-xs="row">

          <md-input-container flex-gt-xs>

            <label>{{__( "Details" )}}</label>
            <textarea class="md-block input-lg md-no-underline" 
                  id="issue-details"
                  ng-model="issue.details">
            </textarea>

          </md-input-container>

        </div>

        <button type="submit" class="btn btn-success" ng-click="save()">{{__( "Create" )}}</button> 

      </form>
      

    </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/ProjectCreateIssueCtrl.js"></script>
@stop
