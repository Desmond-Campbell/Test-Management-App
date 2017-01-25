@extends('index')

@section('title')
{{$project->title}} - {{___( "Project Requirements" )}}
@stop

@section('content')

  <div layout="row">

    @include('navs.project-manage', [ 'active' => 'requirements', 'project_id' => $project->id ])

    <div flex="80" class="main-content" ng-controller="RequirementsCtrl">

      <div class="heading-cell">
        <h2>{{$project->title}} - {{___( "Project Requirements" )}}</h2>
      </div>

      <a href="/projects/{{$project->id}}/requirements/new" type="button" class="btn btn-sm btn-default">{{___( "Add Requirement" )}}</a>

      <br /><br />

      <input type="hidden" id="project_id" value="{{$project->id}}" />

      <div class="panel" ng-repeat="g in requirements" ng-show="requirements.length > 0">

        <div class="panel-title"><h2>@{{g.section_name}}</h2></div>

        <div class="panel-body">

          <table class="table">

            <tr ng-repeat="r in g.requirements">
              
              <td>@{{r.id}}</td>
              <td><a href="/projects/{{$project->id}}/requirements/@{{r.id}}/edit">@{{r.summary}}</a><br />
              {{___( "Created" )}} @{{r.created_at}} | 
                  <a href="/projects/{{$project->id}}/requirements/@{{r.id}}/edit" clss="btn btn-small">Edit</a> 
                  <a href="javascript:;" ng-click="copy(r.id)" clss="btn btn-small">Duplicate</a>
                  <a href="javascript:;" ng-click="delete(r.id)" clss="btn btn-small">Delete</a>
              </td>

            </tr>

          </table>

        </div>

      </div>

      <div class="alert alert-info" ng-show="requirements.length < 1">
        {{___( "There are no requirements setup for this project as yet." )}}
      </div>

    </div>

  </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/RequirementsCtrl.js"></script>
@stop
