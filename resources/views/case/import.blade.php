@extends('index')

@section('title')
{{$project->title}} - {{___( "Import Test Cases" )}}
@stop

@section('content')

  <div class="row-fluid">

    @include('navs.project-manage', [ 'active' => 'cases', 'project_id' => $project->id ])

    <div class="col-lg-10 main-content" ng-controller="ImportCasesCtrl">

      <div class="heading-cell">
        <h2>{{$project->title}} - {{___( "Import Test Cases" )}}</h2>
      </div>

      <form class="form slim-form" role="form" method="post" action="">

        <input type="hidden" id="project_id" value="{{$project->id}}" />

        <div class="alert alert-info">
          {{___( "This tool will allow you to either key in several test cases or import many test cases all at once. Just copy-paste any number of test cases, line by line below and a test case will be created for each." )}}
        </div>

        <div class="form-group">

          <label for="case-list" class="field-required">{{___( "Test Cases" )}}</label>

          <span class="help-block">{{___( "1 test case per line. Empty lines will be stripped automatically." )}}</span>

          <textarea class="form-control input-lg" id="case-list" ng-model="caselist" placeholder="{{___("Paste or type test cases here.")}}" rows="5"></textarea>

        </div>

        <br />

        <button type="button" class="btn btn-lg btn-success" ng-click="import()">{{___( "Import, &amp; New" )}}</button> &nbsp;
        <button type="button" class="btn btn-lg btn-primary" ng-click="importView()">{{___( "Import, &amp; View" )}}</button>

      </form>

    </div>

  </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/ImportCasesCtrl.js"></script>
@stop
