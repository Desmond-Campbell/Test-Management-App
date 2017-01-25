@extends('index')

@section('title')
{{$project->title}} - {{___( "Import Test Cases" )}}
@stop

@section('content')

  <div layout="row">

    @include('navs.project-manage', [ 'active' => 'cases', 'project_id' => $project->id ])

    <div flex="80" class="main-content" ng-controller="ImportCasesCtrl">

      <div class="heading-cell">
        <h2>{{$project->title}} - {{___( "Import Test Cases" )}}</h2>
      </div>

      <form class="form slim-form" role="form" method="post" action="">

        <input type="hidden" id="project_id" value="{{$project->id}}" />

        <div class="alert alert-info">
          {{___( "This tool will allow you to either key in several test cases or import many test cases all at once. Just copy-paste any number of test cases, line by line below and a test case will be created for each." )}}
        </div>

        <div class="form-group">

          <label for="case-section">{{___( "Section" )}}</label>

          <span class="help-block">{{___( "It would be nice to import your cases by sections. Select a section below to apply in bulk to these cases." )}}</span>

          <md-autocomplete
            ng-disabled="isDisabled"
            ng-model="section_name"
            md-no-cache="noCache"
            md-selected-item="selectedItem"
            md-search-text-change="searchTextChange(searchText)"
            md-search-text="searchText"
            md-selected-item-change="selectedItemChange(item)"
            md-items="item in querySearch(searchText)"
            md-item-text="item.name"
            md-min-length="0"
            id="case-section"
            placeholder="{{___( "Choose a section for this test case. Default section is Main." )}}">
            <md-item-template>
              <span md-highlight-text="searchText" md-highlight-flags="^i">@{{item.name}}</span>
            </md-item-template>
          </md-autocomplete>

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
