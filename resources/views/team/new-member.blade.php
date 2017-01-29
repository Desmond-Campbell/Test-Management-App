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
    	{{___( "Use this section to add a member of your organisation to this project's team." )}}
    	<a href="/organisation/people?then_to={{get_url()}}" title="{{___( "We'll take you back here when you're done." )}}">{{___( "Manage the people in your organisation here." )}}</a>
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
        <td ng-show="p.is_member"><a href="/projects/{{$project->id}}/team/@{{p.id}}/edit-access"><i class="fa fa-lock"></i> {{___( "Configure Access" )}}</a> | <a href="javascript:;" ng-click="removeMember(p.id)" class="text-danger"><i class="fa fa-times"></i> {{___( "Remove from Team" )}}</a></td>
        <td ng-show="!p.is_member" class="text-default">{{___( "Not in yet." )}}</td>
        <td ng-show="!p.is_member"><a href="javascript:;" ng-click="createMember(p.id)" class="text-warning"><i class="fa fa-plus"></i> {{___( "Add to Project Team" )}}</a></td>

      </tr>

    </table>

  </div>

@stop

@section('javascript')
  <script src="/js/controllers/ProjectTeamAddCtrl.js"></script>
@stop
