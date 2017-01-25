@extends('index')

@section('title')
{{___( "Create a Project" )}}
@stop

@section('content')

  <div class="row-fluid">

    @include('navs.project-manage')

    <div class="col-lg-10 main-content" ng-controller="NewProjectCtrl">

      <div class="heading-cell">
        <h2>{{___( "Create Project" )}}</h2>
      </div>

      <form class="form slim-form" role="form" method="post" action="">

        <div class="alert alert-info">
          {{___( "Create your project below, then add test cases to them later." )}}
        </div>

        <div class="form-group">

          <label for="project-title">{{___( "Title" )}}</label>

          <input type="text" class="form-control input-lg" id="project-title" ng-model="project.title" />

        </div>

        <br />

        <button type="button" class="btn btn-lg btn-success" ng-click="save()">{{___( "Create" )}}</button>

      </form>

    </div>

  </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/NewProjectCtrl.js"></script>
@stop
