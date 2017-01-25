@extends('index')

@section('title')
{{$project->title}} - {{__( "Project Details" )}}
@stop

@section('content')

  <div layout="row">

    @include('navs.project-manage', [ 'active' => 'details', 'project_id' => $project->id ])

    <div flex="80" class="main-content" ng-controller="ProjectDetailsCtrl">

      <div class="heading-cell">
        <h2>{{$project->title}} - {{__( "Project Details" )}}</h2>
      </div>

      <form class="form slim-form" role="form" method="post" action="">

        <input type="hidden" id="project_id" value="{{$project->id}}" />

        <div class="form-group">

          <label for="project-title">{{__( "Project Title" )}}</label>

          <input type="text" class="form-control input-lg" id="project-title" ng-model="project.title" />

        </div>

        <div class="form-group">

          <label for="project-type">{{__( "Project Type" )}}</label>

          <select class="form-control input-lg" 
                  id="project-type" 
                  ng-model="project.project_type_id"
                  ng-options="t.label for t in project_types track by t.id"
                  >
            
          </select>

        </div>
        
        <div class="form-group">

          <label for="project-description">{{__( "Description" )}}</label>

          <textarea class="form-control input-lg" id="project-description" ng-model="project.description"></textarea>

        </div>

        <br />

        <button type="button" class="btn btn-lg btn-success" ng-click="save()">{{__( "Save" )}}</button>

      </form>

    </div>

  </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/ProjectDetailsCtrl.js"></script>
@stop
