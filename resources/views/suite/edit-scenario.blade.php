@extends('index')

@section('title')
{{$project->title}} - {{___( "Test Suites" )}}
@stop

@section('left-side')

  @include('navs.project-manage', [ 'active' => 'suites', 'project_id' => $project->id ])

@stop

@section('page-heading')
{{___( "Test Suites" )}}
@stop

<?php $layout_toolbar = 1; ?>

@section('toolbar')
  <div id="header-toolbar">
    <ul class="toolbar">
      <li><a href="/projects/{{$project->id}}/suites{{$suite_params}}"><img src="/img/toolbar/view.png" class="toolbar-icon" /> {{___( "View Suites" )}}</a></li>
    </ul>
  </div>
@stop

@section('main')

  <div ng-controller="ProjectSuitesEditScenarioCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    <input type="hidden" id="suite_id" value="{{$suite->id}}" />
    <input type="hidden" id="scenario_id" value="{{$scenario->id}}" />
    <input type="hidden" id="pageconfig" value="<?php print Config::get('hidefull') ? 1 : 0; ?>" />
    
    <h1 class="no-margin-top">{{___( "Edit Test Scenario" )}}</h1>

    <br />

    @if ( Config::get('pageconfig') == 'full-template' )
    <div class="alert alert-info-inverse md-container">
      <strong>{{___( 'Need a larger screen to configure this test scenario?' )}}</strong> <a href="/projects/{{$project->id}}/suites/{{$suite->id}}/edit-scenario/{{$scenario->id}}" target="_top">{{___( "Here you go" )}} <i class="fa fa-long-arrow-right"></i></a>
    </div>
    @endif

      <md-tabs md-border-bottom md-dynamic-height>
        <md-tab label="{{___( "Properties" )}}">
          <div class="md-padding push-down">
      
      <form class="form @if ( Config::get('pageconfig') != 'full-template' ) slim-form @endif" role="form" method="post" action="" onsubmit="return false">

            <div layout-gt-xs="row">

              <md-input-container flex-gt-xs>

                <label>{{__( "Scenario Name" )}}</label>
                <input class="md-block input-lg md-no-underline" 
                      id="scenario-name"
                      maxlength="255" 
                      ng-model="scenario.name" />

              </md-input-container>

            </div>

            <div layout-gt-xs="row">

              <md-input-container flex-gt-xs>

                <label>{{__( "Description" )}}</label>
                <input class="md-block input-lg md-no-underline" 
                      id="scenario-description"
                      ng-model="scenario.description" />

              </md-input-container>

            </div>

          </div>

          <br />

          <button type="submit" class="btn btn-success" ng-click="save()">{{__( "Save" )}}</button> 
          <button type="reset" class="btn btn-danger" ng-click="cancel()">{{__( "Cancel" )}}</button> 

        </form>

        </md-tab>
        <md-tab label="{{___( "Files" )}}">
          <div class="md-padding push-down">

            <div layout="flex">

              <div flex="45">
                <h4>{{___( "Select file(s) from your computer and click Upload." )}}</h4>
                <input type="file" id="file1" name="file" multiple ng-files="getTheFiles($files)" /> <br />
                <button type="submit" class="btn btn-warning" ng-click="uploadFiles()">{{__( "Upload" )}}</button> 
              </div>

              <div flex="5">
              </div>

              <div flex="50" class="short-div">

                <ul class="list-group">
                  <li class="list-group-item" ng-repeat="f in scenariofiles">
                    <table>
                      <tr>
                        <td width="5%">
                          <button class="btn btn-default" ng-click="deleteScenarioFile(f.id)"><i class="fa fa-trash"></i></button>
                        </td>
                        <td style="padding-left:15px">
                          @{{f.name}}
                        </td>
                      </tr>
                    </table>
                  </li>
                </ul>

              </div>
            
            </div>
          </div>
        </md-tab>
        
      </md-tabs>

  </div>
@stop

@section('javascript')
  <script src="/js/controllers/ProjectSuitesEditScenarioCtrl.js"></script>
@stop
