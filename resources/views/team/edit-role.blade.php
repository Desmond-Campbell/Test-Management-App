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
      <li><a href="/projects/{{$project->id}}/team/new-role"><img src="/img/toolbar/new.png" class="toolbar-icon" /> {{___( "Add a Role" )}}</a></li>
      <li><a href="/projects/{{$project->id}}/team/roles"><img src="/img/toolbar/view.png" class="toolbar-icon" /> {{___( "View Roles" )}}</a></li>
    </ul>
  </div>
@stop

@section('main')

  <div ng-controller="ProjectTeamEditRoleCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    <input type="hidden" id="role_id" value="{{$role_id}}" />
    
    <div class="md-container">

      <h1 class="no-margin-top">
        @{{role.name}} {{___( "Role" )}}
      </h1>

      <br />

      <div layout-gt-xs="row">

        <md-input-container flex-gt-xs>

          <label>{{__( "Name of Role" )}}</label>
          <input class="md-block input-lg md-no-underline" 
                id="role-name"
                maxlength="50" 
                ng-model="role.name"
                onEnter="saveRole()" 
                ng-blur="saveRole()" />

        </md-input-container>

      </div>

      <br />

      <div layout-gt-xs="row">

        <md-input-container flex-gt-xs>

          <input class="md-block input-lg md-no-underline" 
                id="role-description"
                maxlength="72" 
                placeholder="{{___( "Short description" )}}"
                ng-blur="saveRole()" 
                onEnter="saveRole()" 
                ng-model="role.description" />

        </md-input-container>

      </div>

    </div>

    <h2>{{___( "Permissions" )}}</h2>

    <div ng-cloak class="md-container push-down">
      
      <div class="text-info">{{___( "These are the default set of permissions on this role, which may be superceded by others specified in the list of override or restriction permissions configured on a team member's account." )}}</div><br />

      <div ng-show="dirty_perms">
        <button class="btn btn-success btn-sm" ng-click="savePerms()">{{___( "Save Changes" )}}</button>
        &nbsp;
        <button class="btn btn-danger btn-sm" ng-click="getPerms()">{{___( "Undo" )}}</button><br /><br />
      </div>

      <fieldset class="demo-fieldset" >
        <div layout="row" layout-wrap flex>
          <div flex-xs flex="50" ng-show="perms.length > 5">
            <md-checkbox aria-label="{{___( "Select All" )}}"
                         ng-checked="isChecked()"
                         md-indeterminate="isIndeterminate()"
                         ng-click="toggleAll()">
              <span ng-show="isChecked()">{{___( "Clear Selection" )}}</span>
              <span ng-show="!isChecked()">{{___( "Select All" )}}</span>
            </md-checkbox>
          </div>
          <div class="demo-select-all-checkboxes perm-list-item" flex="100" ng-repeat="perm in perms">
            <md-checkbox ng-checked="exists(perm, selected)" ng-click="toggle(perm, selected)" aria-label=".">
             @{{ perm_info[perm].name }} &nbsp; <span class="small-description">@{{ perm_info[perm].description }}</span>
            </md-checkbox>
          </div>
        </div>
      </fieldset>

    </div>

  </div>

@stop

@section('javascript')
  <script src="/js/controllers/ProjectTeamEditRoleCtrl.js"></script>
@stop
