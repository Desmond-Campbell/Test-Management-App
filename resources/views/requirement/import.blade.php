@extends('index')

@section('title')
{{$project->title}} - {{___( "Import Project Requirements" )}}
@stop

@section('content')

  <div layout="row">

    @include('navs.project-manage', [ 'active' => 'requirements', 'project_id' => $project->id ])

    <div flex="80" class="main-content" ng-controller="ImportRequirementsCtrl">

      <div class="heading-cell">
        <h2>{{$project->title}} - {{___( "Import Project Requirements" )}}</h2>
      </div>

      <form class="form slim-form" role="form" method="post" action="">

        <input type="hidden" id="project_id" value="{{$project->id}}" />

        <div class="alert alert-info">
          {{___( "This tool will allow you to either key in several requirements or import many requirements all at once. Just copy-paste any number of requirements, line by line below and a requirement will be created for each." )}}
        </div>

        <div class="form-group">

          <label for="requirement-section">{{___( "Section" )}}</label>

          <span class="help-block">{{___( "Importing your requirements by sections will make your life 10 times easier. Select a section below to apply in bulk to these requirements." )}}</span>

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
            id="requirement-section"
            placeholder="{{___( "Choose a section for this test requirement. Default section is Main." )}}">
            <md-item-template>
              <span md-highlight-text="searchText" md-highlight-flags="^i">@{{item.name}}</span>
            </md-item-template>
          </md-autocomplete>

        </div>

        <div class="form-group">

          <label for="requirement-list" class="field-required">{{___( "Project Requirements" )}}</label>

          <span class="help-block">{{___( "1 requirement per line. Empty lines will be stripped automatically." )}}</span>

          <textarea class="form-control input-lg" id="requirement-list" ng-model="requirementlist" placeholder="{{___("Paste or type project requirements here.")}}" rows="10"></textarea>

        </div>

        <div class="form-group">

          <label for="requirement-section">{{___( "Parent Requirement" )}}</label>

          <span class="help-block">{{___( "If these are a sub-requirements to another, select the main requirement below." )}}</span>

          <md-autocomplete
            ng-disabled="isDisabled"
            ng-model="main_requirement_name"
            md-no-cache="noCache"
            md-selected-item="selectedItemR"
            md-search-text-change="searchTextChangeR(searchTextR)"
            md-search-text="searchTextR"
            md-selected-item-change="selectedItemChangeR(itemR)"
            md-items="itemR in querySearchR(searchTextR)"
            md-item-text="itemR.name"
            md-min-length="0"
            id="requirement-section"
            placeholder="{{___( "Choose a parent requirement for this requirement." )}}">
            <md-item-template>
              <span md-highlight-text="searchTextR" md-highlight-flags="^i">@{{itemR.name}}</span>
            </md-item-template>
          </md-autocomplete>

        </div>

        <br />

        <button type="button" class="btn btn-lg btn-success" ng-click="import()">{{___( "Import, &amp; New" )}}</button> &nbsp;
        <button type="button" class="btn btn-lg btn-primary" ng-click="importView()">{{___( "Import, &amp; View" )}}</button>

      </form>

    </div>

  </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/ImportRequirementsCtrl.js"></script>
@stop
