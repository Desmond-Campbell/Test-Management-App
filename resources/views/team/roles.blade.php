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
      <li><a href="/projects/{{$project->id}}/team/new-role"><img src="/img/toolbar/new.png" class="toolbar-icon" /> {{___( "Add Role" )}}</a></li>
    </ul>
  </div>
@stop

@section('main')

  <div ng-controller="ProjectTeamRolesCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    
    <h1 class="no-margin-top">{{___( "Roles" )}}</h1>

    <table class="table table-middle-align push-down sm-container">

      <tbody ng-repeat="r in roles">
        <tr>
          
          <td><h4>@{{r.name}}</h4></td>
          <td><a href="/projects/{{$project->id}}/team/@{{r.id}}/edit-role"><i class="fa fa-gear"></i> {{___( "Edit &amp; Configure Permissions" )}}</a></td>

        </tr>

        <tr>

          <td colspan="2" class="small-description">
            <em>@{{r.name}}</em>: @{{r.description}}
          </td>

        </tr>

      </tbody>

    </table>

  </div>

@stop

@section('javascript')
  <script src="/js/controllers/ProjectTeamRolesCtrl.js"></script>
@stop
