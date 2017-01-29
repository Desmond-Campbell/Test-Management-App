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
      <li><a href="/projects/{{$project->id}}/team/roles"><img src="/img/toolbar/view.png" class="toolbar-icon" /> {{___( "View Roles" )}}</a></li>
    </ul>
  </div>
@stop

@section('main')

  <div ng-controller="ProjectTeamAddRoleCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    
    <h1 class="no-margin-top">{{___( "Create a Role" )}}</h1>

    <br />

    <div class="alert alert-info-light md-container">
    	{{___( "Use this section to add a role to your project's team." )}}
    	<a href="/organisation/people?then_to={{get_url()}}" title="{{___( "We'll take you back here when you're done." )}}">{{___( "Manage the people in your organisation here." )}}</a>
    </div>

    <form class="form slim-form" role="form" method="post" action="" onsubmit="return false">

        <div layout-gt-xs="row">

          <md-input-container flex-gt-xs>

            <label>{{__( "Name of Role" )}}</label>
            <input class="md-block input-lg md-no-underline" 
                  id="role-name"
                  maxlength="50" 
                  ng-model="role.name" />

          </md-input-container>

        </div>

        <div layout-gt-xs="row">

          <md-input-container flex-gt-xs>

            <label>{{__( "Short Description" )}}</label>
            <input class="md-block input-lg md-no-underline" 
                  id="role-description"
                  maxlength="72" 
                  ng-model="role.description" />

          </md-input-container>

        </div>

        <div class="text-info md-block">
          {{___( "You can copy permissions from an existing role into this new one. Just select it from the list below." )}}
        </div>

        <div layout-gt-xs="row" ng-show="roles.length > 0">

          <md-input-container flex-gt-xs>

            <md-select ng-model="role.copy" placeholder="{{___( "Select an existing role") }}" class="md-block md-no-underline">
              <md-option ng-repeat="r in roles" value="@{{r}}">@{{r}}</md-option>
            </md-select>

          </md-input-container>

        </div>

        <button type="submit" class="btn btn-success" ng-click="save()">{{__( "Create" )}}</button> 

      </form>

  </div>

@stop

@section('javascript')
  <script src="/js/controllers/ProjectTeamAddRoleCtrl.js"></script>
@stop
