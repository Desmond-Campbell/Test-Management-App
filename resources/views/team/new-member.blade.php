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
      <li><a href="/projects/{{$project->id}}/team"><img src="/img/toolbar/view.png" class="toolbar-icon" /> {{___( "View Members" )}}</a></li>
    </ul>
  </div>
@stop

@section('main')

  <div ng-controller="ProjectTeamAddCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    
    <h1 class="no-margin-top">{{___( "Add Team Member" )}}</h1>

    <br />

    <div class="alert alert-info-light md-container">
    	{{___( "Use this section to add a member of your network to this project's team." )}}
    	<a href="http://my.{{env('APP_DOMAIN')}}/network/{{\App\Options::get('network_id')}}/people" target="_blank">{{___( "Manage the people in your network here." )}}</a>
    </div>

      <p><small><md-checkbox ng-model="hide_members" aria-label="{{___( "Hide existing team members." ) }}" ng-click="changeFilter()">
        {{___( "Hide those are already on the team." )}}
      </md-checkbox></small></p>

    <table class="table table-middle-align push-down md-container">

      <tr>

        <th>{{___( "Name" ) }}</th>
        <th>{{___( "Status" )}}</th>
        <th>{{___( "Actions" )}}</th>

      </tr>

      <tr ng-repeat="p in people">
        
        <td>@{{p.name}}</td>
        <td ng-show="p.is_member" class="text-success"><i class="fa fa-check"></i> {{___( "Already in." )}}</td>
        <td ng-show="p.is_member">@if ( pass( 'team.edit_member', $project->id) )<a href="/projects/{{$project->id}}/team/@{{p.member_id}}/edit-access"><i class="fa fa-lock"></i> {{___( "Configure Access" )}}</a>@endif</td>
        <td ng-show="!p.is_member" class="text-default">
          <span ng-show="!p.removed">{{___( "Not in yet." )}}</span>
          <span ng-show="p.removed" class="text-danger">{{___( "Removed" )}}</span>
        </td>
        <td ng-show="!p.is_member">@if ( pass( 'team.add_member', $project->id) )<a href="javascript:;" ng-click="createMember(p.id)" class="text-warning"><i class="fa fa-plus"></i> {{___( "Add to Project Team" )}}</a>@endif</td>

      </tr>

    </table>

  </div>

@stop

@section('javascript')
  <script src="/js/controllers/ProjectTeamAddCtrl.js"></script>
@stop
