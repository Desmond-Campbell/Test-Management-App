@extends('index')

@section('title')
{{$project->title}} - {{___( "Test Batches" )}}
@stop

@section('left-side')

  @include('navs.project-manage', [ 'active' => 'tests', 'project_id' => $project->id ])

@stop

@section('page-heading')
{{___( "Test Batches" )}}
@stop

<?php $layout_toolbar = 1; ?>

@section('toolbar')
  <div id="header-toolbar">
    <ul class="toolbar">
      <li><a href="/projects/{{$project->id}}/tests/{{$test->id}}"><img src="/img/toolbar/view.png" class="toolbar-icon" /> {{___( "View Test Run" )}}</a></li>
    </ul>
  </div>
@stop

@section('main')

  <div ng-controller="ProjectBatchListCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    <input type="hidden" id="test_id" value="{{$test->id}}" />
    
    <h1 class="no-margin-top">{{$test->name}} - {{___( "Batches" )}}</h1>

    <div class="alert alert-info-light push-down">
    {{___( "A batch is an instance of a test that is currently being executed. Dispatching a test run means starting a new batch for the testers currently assigned, and therefore only one batch can run at a time. If you want other testers to start testing, you can duplicate the test run and dispatch the new one. If you stop a batch, you can't restart it. However, you may pause the batch if you need testing to stop temporarily." )}}
    </div>

    <div class="push-down">
      <button class="btn btn-danger" ng-click="startBatch()">Dispatch Now</button>
    </div>

    <table class="table table-middle-align push-down sm-container">

      <tr>

        <th>{{___( "Batch #" ) }}</th>
        <th>{{___( "Started When" ) }}</th>
        <th>{{___( "Status" ) }}</th>
        <th>&nbsp;</th>

      </tr>

      <tr ng-repeat="b in batches">
        
        <td>@{{b.id}}</td>
        <td>@{{b.created_at}}</td>
        <td>@{{b.status}}</td>
        <td><a href="javascript:;" ng-click="stopBatch(b.id,$index)"><i class="fa fa-times"></i>&nbsp; {{___( "Stop" )}}</a> &nbsp; 
          <a href="/projects/{{$project->id}}/tests/{{$test->id}}/batch/@{{b.id}}/launch"><i class="fa fa-paper-plane"></i>&nbsp; {{___( "Launch" )}}</a> &nbsp; 
          <a href="/projects/{{$project->id}}/tests/{{$test->id}}/results/@{{b.id}}"><i class="fa fa-bars"></i>&nbsp; {{___( "Results" )}}</a></td>

      </tr>

    </table>

  </div>

@stop

@section('javascript')
  <script src="/js/controllers/ProjectBatchListCtrl.js"></script>
@stop
