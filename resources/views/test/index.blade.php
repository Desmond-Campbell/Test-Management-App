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
  <div id="header-toolbar" ng-controller="ProjectTestsListCtrl">
    <ul class="toolbar">
      <li><a href="javascript:;" ng-click="addTest()"><img src="/img/toolbar/new.png" class="toolbar-icon" /> {{___( "New Test Run" )}}</a></li>
    </ul>
  </div>
@stop

@section('main')

  <div ng-controller="ProjectTestsListCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    
    <h1 class="no-margin-top">{{___( "Test Runs" )}}</h1>

    <table class="table table-middle-align push-down sm-container">

      <tr>

        <th>{{___( "Name" ) }}</th>
        <th>{{___( "Status" ) }}</th>
        <th>&nbsp;</th>

      </tr>

      @foreach ( $tests as $t )

      <tr>
        
        <td>{{$t->name}}</td>
        <td>{{$t->status}}</td>
        <td><a href="/projects/{{$project->id}}/tests/{{$t->id}}/dispatch"><i class="fa fa-paper-plane"></i>&nbsp; {{___( "Dispatch" )}}</a> &nbsp; &nbsp; <a href="/projects/{{$project->id}}/tests/{{$t->id}}"><i class="fa fa-gear"></i> &nbsp;{{___( "Manage" )}}</a></td>

      </tr>

      @endforeach

    </table>

  </div>

@stop

@section('javascript')
  <script src="/js/controllers/ProjectTestsListCtrl.js"></script>
@stop
