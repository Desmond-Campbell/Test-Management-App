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

@section('main')

  <div ng-controller="ProjectTeamListCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    
    <h1 class="no-margin-top">{{___( "Team Members" )}}</h1>

    <a href="/projects/{{$project->id}}/team/new-member" type="button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> &nbsp; {{___( "Add Member" )}}</a>

    <br /><br />

    <table class="table table-middle-align push-down sm-container">

      <tr>

        <th>{{___( "Name" ) }}</th>
        <th>{{___( "Class" ) }}</th>
        <th>&nbsp;</th>

      </tr>

      <tr ng-repeat="m in members">
        
        <td>@{{m.name}}</td>
        <td>@{{m.class}}</td>
        <td><a href="/projects/{{$project->id}}/team/@{{m.id}}/edit-access"><i class="fa fa-lock"></i> {{___( "Configure Access" )}}</a></td>

      </tr>

    </table>

  </div>

@stop

@section('javascript')
  <script src="/js/controllers/ProjectTeamListCtrl.js"></script>
@stop
