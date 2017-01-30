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
  <div id="header-toolbar" ng-controller="ProjectTeamEditAccessCtrl">
    <ul class="toolbar">
      <li><a href="javascript:;" ng-click="removeMember()"><img src="/img/toolbar/remove.png" class="toolbar-icon" /> {{___( "Remove from Project" )}}</a></li>
      <li><a href="/organisation/person/{{$member_user_id}}/view"><img src="/img/toolbar/person.png" class="toolbar-icon" /> {{___( "View in Organisation" )}}</a></li>
      <li><a href="/projects/{{$project->id}}/team/new-member"><img src="/img/toolbar/new.png" class="toolbar-icon" /> {{___( "Add Another Member" )}}</a></li>
    </ul>
  </div>
@stop

@section('main')

  <div ng-controller="ProjectTeamEditAccessCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    <input type="hidden" id="member_id" value="{{$member_id}}" />
    <input type="hidden" id="member_user_id" value="{{$member_user_id}}" />
    
    <h1 class="no-margin-top">@{{member.name}}</h1>

    <br />

    <div class="text-warning md-container">
    	{{___( "Use this section to control what a team member can or cannot do." )}}
    </div>

    <div ng-cloak class="md-container push-down">
      <md-content>
        <md-tabs md-dynamic-height md-border-bottom>
          <md-tab label="{{___( "Roles" )}}">
            <md-content class="md-padding white-bg">
              
              <div class="text-info">{{___( "Which role or roles do you want this member to be assigned to, for this project?" )}}</div><br />

              <div ng-show="dirty_roles">
                <button class="btn btn-success btn-sm" ng-click="saveRoles()">{{___( "Save Changes" )}}</button>
                &nbsp;
                <button class="btn btn-danger btn-sm" ng-click="getRoles()">{{___( "Undo" )}}</button><br /><br />
              </div>

              <fieldset class="demo-fieldset" >
                <div layout="row" layout-wrap flex>
                  <div flex-xs flex="50" ng-show="roles.length > 5">
                    <md-checkbox aria-label="{{___( "Select All" )}}"
                                 ng-checked="isChecked()"
                                 md-indeterminate="isIndeterminate()"
                                 ng-click="toggleAll()">
                      <span ng-show="isChecked()">{{___( "Clear Selection" )}}</span>
                      <span ng-show="!isChecked()">{{___( "Select All" )}}</span>
                    </md-checkbox>
                  </div>
                  <div class="demo-select-all-checkboxes perm-list-item" flex="100" ng-repeat="role in roles">
                    <md-checkbox ng-checked="exists(role, selected)" ng-click="toggle(role, selected)" aria-label=".">
                     @{{ role_info[role].name }} &nbsp; <span class="small-description">@{{ role_info[role].description }}</span>
                    </md-checkbox>
                  </div>
                </div>
              </fieldset>

            </md-content>
          </md-tab>
          <md-tab label="{{___( "Overrides" )}}">
            <md-content class="md-padding white-bg">
              <div class="text-info">{{___( "If you want to give special access to this member but you don't wish to add that permission to any of their roles, you can configure override permissions here." )}}</div><br />

              <div ng-show="dirty_overrides">
                <button class="btn btn-success btn-sm" ng-click="saveOverrides()">{{___( "Save Changes" )}}</button>
                &nbsp;
                <button class="btn btn-danger btn-sm" ng-click="getOverrides()">{{___( "Undo" )}}</button><br /><br />
              </div>

              <fieldset class="demo-fieldset" >
                <div layout="row" layout-wrap flex>
                  <div flex-xs flex="50" ng-show="overrides.length > 5">
                    <md-checkbox aria-label="{{___( "Select All" )}}"
                                 ng-checked="isCheckedO()"
                                 md-indeterminate="isIndeterminateO()"
                                 ng-click="toggleAllO()">
                      <span ng-show="isCheckedO()">{{___( "Clear Selection" )}}</span>
                      <span ng-show="!isCheckedO()">{{___( "Select All" )}}</span>
                    </md-checkbox>
                  </div>
                  <div class="demo-select-all-checkboxes perm-list-item" flex="100" ng-repeat="override in overrides">
                    <md-checkbox ng-checked="existsO(override, selectedO)" ng-click="toggleO(override, selectedO)" aria-label=".">
                     @{{ override_info[override].name }} &nbsp; <span class="small-description">@{{ override_info[override].description }}</span>
                    </md-checkbox>
                  </div>
                </div>
              </fieldset>

            </md-content>
          </md-tab>
          <md-tab label="{{___( "Restrictions" )}}">
            <md-content class="md-padding white-bg">
              <div class="text-info">{{___( "This works opposite to override permissions, in that, you may want to restrict a member from doing something in particular, even though their role allows it. Any permission you select here will supercede every other security setting for this member." )}}</div><br />

              <div ng-show="dirty_restrictions">
                <button class="btn btn-success btn-sm" ng-click="saveRestrictions()">{{___( "Save Changes" )}}</button>
                &nbsp;
                <button class="btn btn-danger btn-sm" ng-click="getRestrictions()">{{___( "Undo" )}}</button><br /><br />
              </div>

              <fieldset class="demo-fieldset" >
                <div layout="row" layout-wrap flex>
                  <div flex-xs flex="50" ng-show="restrictions.length > 5">
                    <md-checkbox aria-label="{{___( "Select All" )}}"
                                 ng-checked="isCheckedR()"
                                 md-indeterminate="isIndeterminateR()"
                                 ng-click="toggleAllR()">
                      <span ng-show="isCheckedR()">{{___( "Clear Selection" )}}</span>
                      <span ng-show="!isCheckedR()">{{___( "Select All" )}}</span>
                    </md-checkbox>
                  </div>
                  <div class="demo-select-all-checkboxes perm-list-item" flex="100" ng-repeat="restriction in restrictions">
                    <md-checkbox ng-checked="existsR(restriction, selectedR)" ng-click="toggleR(restriction, selectedR)" aria-label=".">
                     @{{ restriction_info[restriction].name }}<br /><span class="small-description">@{{ restriction_info[restriction].description }}</span>
                    </md-checkbox>
                  </div>
                </div>
              </fieldset>

            </md-content>
          </md-tab>
        </md-tabs>
      </md-content>
    </div>

  </div>

@stop

@section('javascript')
  <script src="/js/controllers/ProjectTeamEditAccessCtrl.js"></script>
@stop
