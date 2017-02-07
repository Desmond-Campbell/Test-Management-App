@extends('index')

@section('title')
{{$project->title}} - {{___( "Team Members" )}}
@stop

@section('left-side')

  @include('navs.project-manage', [ 'active' => 'team', 'project_id' => $project->id ])

@stop

@section('page-heading')
{{___( "Project Team" )}}
@stop

<?php $layout_toolbar = 1; ?>

@section('toolbar')
  <div id="header-toolbar">
    <ul class="toolbar">
      <li><a href="/projects/{{$project->id}}/team/new-member"><img src="/img/toolbar/new.png" class="toolbar-icon" /> {{___( "Add Member" )}}</a></li>
    </ul>
  </div>
@stop

@section('main')

  <div ng-controller="ProjectTeamListCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    
    <h1 class="no-margin-top">{{___( "Team Members" )}}</h1>

    <table class="table table-middle-align push-down sm-container">

      <tr>

        <th>{{___( "Name" ) }}</th>
        <th>{{___( "Class" ) }}</th>
        <th>&nbsp;</th>

      </tr>

      <tr ng-repeat="m in members">
        
        <td ng-show="!m.is_removed">@{{m.name}}</td>
        <td ng-show="m.is_removed" class="text-struck text-danger">@{{m.name}}</td>

        <td ng-show="!m.is_removed">@{{m.class}}</td>
        <td ng-show="m.is_removed" class="text-struck text-danger">@{{m.class}}</td>
        
        <td ng-show="!m.is_removed"><a href="/projects/{{$project->id}}/team/@{{m.id}}/edit-access"><i class="fa fa-lock"></i> {{___( "Configure Access" )}}</a></td>
        <td ng-show="m.is_removed"><a href="/projects/{{$project->id}}/team/new-member"><i class="fa fa-bars"></i> {{___( "Reinstate from Network" )}}</a></td>

      </tr>

    </table>

  </div>

@stop

@section('javascript')
  <script src="/js/controllers/ProjectTeamListCtrl.js"></script>
@stop
