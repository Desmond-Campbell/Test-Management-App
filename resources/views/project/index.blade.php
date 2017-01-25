@extends('index')

@section('title')
{{___( "Projects" )}}
@stop

@section('content')

  <div class="row-fluid">

    @include('navs.project-list')

    <div class="col-lg-10 main-content" ng-controller="ProjectListCtrl">

      <div class="heading-cell">
        <h2>{{___( "Projects" )}}</h2>
      </div>

      <a href="/projects/new" type="button" class="btn btn-sm btn-default">{{___( "Create a Project" )}}</a>

      <br /><br />

      <ul class="grid-list project-list">

        <li ng-repeat="p in projects">
          <span class="grid-title">@{{p.title}}</span><br />
          <span class="grid-description">@{{p.description}}</span><br />
          <a href="/projects/@{{p.id}}/dashboard" class="btn btn-primary">Open</a>
        </li>

      </ul>

    </div>

  </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/ProjectListCtrl.js"></script>
@stop
