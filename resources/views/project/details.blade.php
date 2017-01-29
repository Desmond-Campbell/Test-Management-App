@extends('index')

@section('title')
{{$project->title}} - {{__( "Project Details" )}}
@stop

@section('left-side')

  @include('navs.project-manage', [ 'active' => 'details', 'project_id' => $project->id ])

@stop

@section('page-heading')
{{___( "Edit Project Details" )}}
@stop

@section('load-css')
    <link href="/js/vendor/md-color-picker/mdColorPicker.css" rel="stylesheet">
@stop

@section('main')

    <div ng-controller="ProjectDetailsCtrl">

      <form class="form slim-form" role="form" method="post" action="" onsubmit="return false">

        <input type="hidden" id="project_id" value="{{$project->id}}" />

        <div class="alert alert-info-light">
          <i class="fa fa-question-circle"></i> &nbsp; {{___( "Click on an existing value to change it. When you're done, click 'Save'." )}}
        </div>

        <div layout-gt-xs="row">

          <md-input-container flex-gt-xs>

            <label>{{__( "Project Title" )}}</label>
            <input class="md-block input-lg md-no-underline" 
                  id="project-title"
                  maxlength="50" 
                  ng-model="project.title" />

          </md-input-container>

        </div>

        <div layout-gt-xs="row">

          <md-input-container flex-gt-xs>

            <label>{{__( "Project Type" )}}</label> <br />

            <md-select ng-model="project.type" placeholder="{{___( "Select a Project Type") }}" class="md-block md-no-underline">
              <md-option ng-repeat="t in project_types" value="@{{t}}">@{{t}}</md-option>
            </md-select>

          </md-input-container>

        </div>

        <div layout-gt-xs="row">

          <md-input-container flex-gt-xs>

            <label>{{__( "Description" )}}</label>

            <textarea class="md-block md-no-underline" 
                      md-no-float id="project-description" 
                      ng-model="project.description" 
                      maxlength="255"
                      rows="5"></textarea>

          </md-input-container>

        </div>

        <div layout-gt-xs="row">

          <md-input-container flex-gt-xs>

            <label style="font-size: 16px">{{__( "Colour" )}}</label><br />

            <div style="width: 150px !important; border: none !important" readonly="readonly" disabled="disabled" 
                md-color-picker 
                ng-model="project.colour"
                md-color-hsl="false"
                md-color-rgb="false"
                md-color-history="false"
                md-color-sliders="false"
                md-color-spectrum="true"
                md-color-generic-palette="false"
                md-color-material-palette="false"
                md-color-clear-button="false"
                open-on-input="true">

            </div>

          </md-input-container>

        </div>

        <br />

        <button type="submit" class="btn btn-success" ng-click="saveAndExit()">{{__( "Save, and Exit" )}}</button> &nbsp; 
        <button type="button" class="btn btn-primary" ng-click="justSave()">{{__( "Just Save" )}}</button> &nbsp; 
        <button type="button" class="btn btn-warning" ng-click="getProject()">{{__( "Discard Changes" )}}</button>

      </form>

    </div>

@stop

@section('javascript')
  <script src="/js/controllers/ProjectDetailsCtrl.js"></script>
@stop
