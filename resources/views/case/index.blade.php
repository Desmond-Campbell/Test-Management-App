@extends('index')

@section('title')
{{$project->title}} - {{___( "Test Cases" )}}
@stop

@section('content')

  <div class="row-fluid">

    @include('navs.project-manage', [ 'active' => 'cases', 'project_id' => $project->id ])

    <div class="col-lg-10 main-content" ng-controller="CasesCtrl">

      <div class="heading-cell">
        <h2>{{$project->title}} - {{___( "Test Cases" )}}</h2>
      </div>

      <a href="/projects/{{$project->id}}/cases/new" type="button" class="btn btn-sm btn-default">{{___( "Add Test Case" )}}</a>

      <br /><br />

      <input type="hidden" id="project_id" value="{{$project->id}}" />

      <table class="table">

        <tr>

          <th>{{___( "ID" )}}</th>
          <th>{{___( "Title" ) }}</th>
          <th>{{___( "Section" ) }}</th>
          <th>{{___( "When") }}</th>
          <th>&nbsp;</th>

        </tr>

        <tr ng-repeat="c in cases">
          
          <td>@{{c.id}}</td>
          <td><a href="/projects/{{$project->id}}/cases/@{{c.id}}/edit">@{{c.title}}</a></td>
          <td>@{{c.section_name}}</td>
          <td>@{{c.created_at}}</td>
          <td><a href="/projects/{{$project->id}}/cases/@{{c.id}}/edit" clss="btn btn-small">Edit</a> 
              <a href="javascript:;" ng-click="copy(c.id)" clss="btn btn-small">Duplicate</a>
              <a href="javascript:;" ng-click="delete(c.id)" clss="btn btn-small">Delete</a>
          </td>

        </tr>

      </table>

    </div>

  </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/CasesCtrl.js"></script>
@stop
