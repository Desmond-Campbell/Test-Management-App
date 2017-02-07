@extends('index-full')

@section('title')
{{___( "Projects" )}}
@stop

@section('main')

    <div class="main-content" ng-controller="ProjectListCtrl">

      <div class="heading-cell">
        <h1>{{___( "Projects" )}}</h1>
      </div>

      <br />

      @if ( orgpass( "projects.create_project" ) )

      <button class="btn btn-sm btn-success" ng-click="newProject()" id="btn-create-project" ng-show="!newProjectMode">&nbsp; <i class="fa fa-plus"></i> &nbsp; {{___("Create a Project")}} &nbsp;</button> 

      <div class="form-group" layout="row" ng-show="newProjectMode">
        <div flex="50">
          <input type="text" class="form-control col-md-4" id="new-project-title" ng-model="project.title" placeholder="{{___( "Enter a title for your new project." )}}" onEnter="createProject()" />
        </div>
        <div flex>
          &nbsp;&nbsp;
          <button type="submit" class="btn btn-sm btn-success" ng-click="createProject()">&nbsp; <i class="fa fa-check"></i> &nbsp; {{___( "Continue" )}}</button> &nbsp;
          <button type="button" class="btn btn-sm btn-danger" ng-click="cancelNewProject()">&nbsp; <i class="fa fa-times"></i> &nbsp; {{___( "Nevermind" )}}</button>
        </div>
      </div>

      <br />

      @endif

      <ul class="grid-list project-list">

        <li ng-repeat="p in projects" md-white-frame="1">
        
          <md-card>
            <md-card-title>
              <md-card-title-text>
                <span class="grid-headline"><a href="/projects/@{{p.id}}">@{{p.title}}</a></span>
                <p class="grid-subhead">

                  <excerpt ng-show="p.description.length">@{{p.description | shorten : true : 72 : '...' }}</excerpt>
                  <excerpt ng-show="!p.description.length">No description...<br /><br /></excerpt>

                </p>
              </md-card-title-text>
            </md-card-title>
            <md-card-actions layout="row">
              <div flex="50">
                &nbsp;<a href="/projects/@{{p.id}}" class="btn btn-sm btn-default">&nbsp; <i class="fa fa-paper-plane"></i> &nbsp; {{___( "Select" ) }} &nbsp;</a>
              </div>
              <div flex="50">
                 <p class="project-modified-date">Modified @{{p.updated_at | relativeTime}} &nbsp;</p>
              </div>
            </md-card-actions>
          </md-card>

        </li>

      </ul>

    </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/ProjectListCtrl.js"></script>
@stop
