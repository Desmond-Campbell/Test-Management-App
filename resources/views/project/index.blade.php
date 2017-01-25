@extends('index')

@section('title')
{{___( "Projects" )}}
@stop

@section('content')

  <div layout="row">

    @include('navs.project-list')

    <div flex="80" class="main-content" ng-controller="ProjectListCtrl">

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
