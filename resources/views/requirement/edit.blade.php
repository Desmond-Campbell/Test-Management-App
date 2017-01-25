@extends('index')

@section('title')
{{$project->title}} - {{___( "Edit Project Requirement" )}}
@stop

@section('content')

  <div layout="row">

    @include('navs.project-manage', [ 'active' => 'requirements', 'project_id' => $project->id ])

    <div flex="80" class="main-content" ng-controller="EditRequirementCtrl">

      <div class="heading-cell">
        <h2>{{$project->title}} - {{___( "Edit Project Requirement" )}}</h2>
      </div>

      <form class="form slim-form" role="form" method="post" action="">

        <input type="hidden" id="project_id" value="{{$project->id}}" />
        <input type="hidden" id="requirement_id" value="{{$requirement->id}}" />

        <div class="alert alert-default">
          {{___( "A requirement is a description of a feature to be delivered in your project. Requirements can be made sub-requirements of other requirements." )}}
        </div>

        <div class="form-group">

          <label for="requirement-summary" class="field-required">{{___( "Summary" )}}</label>

          <input type="text" class="form-control input-lg" id="requirement-summary" ng-model="requirement.summary" placeholder="{{___( "Enter your actual requirement here." )}}" />

        </div>

        <div class="form-group">

          <label for="requirement-description">{{___( "Description" )}}</label>

          <span class="help-block">{{___( "Describe your requirement here in detail, if you wish." )}}</span>

          <textarea class="form-control input-lg" id="requirement-description" ng-model="requirement.description" placeholder="{{___("This is optional.")}}" rows="5"></textarea>

        </div>

        <div class="form-group">

          <label for="requirement-section">{{___( "Section" )}}</label>

          <span class="help-block">{{___( "Sections are literal sections that you use to organise project requirements, as you do with test cases." )}}</span>

          <md-autocomplete
            ng-disabled="isDisabled"
            ng-model="requirement.section_name"
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

          <label for="requirement-section">{{___( "Parent Requirement" )}}</label>

          <span class="help-block">{{___( "If this is a sub-requirement to another, select the main requirement below." )}}</span>

          <md-autocomplete
            ng-disabled="isDisabled"
            ng-model="requirement.parent_requirement_name"
            md-no-cache="noCache"
            md-selected-item="selectedItemR"
            md-search-text-change="searchTextChangeR(searchTextR)"
            md-search-text="searchTextR"
            md-selected-item-change="selectedItemChangeR(itemR)"
            md-items="itemR in querySearchR(searchTextR)"
            md-item-text="itemR.summary"
            md-min-length="0"
            id="requirement-section"
            placeholder="{{___( "Choose a parent requirement for this requirement." )}}">
            <md-item-template>
              <span md-highlight-text="searchTextR" md-highlight-flags="^i">@{{itemR.summary}}</span>
            </md-item-template>
          </md-autocomplete>

        </div>

        <div class="form-group">

          <label for="requirement-children" class="field-required">{{___( "Sub-requirements" )}}</label>

          <span class="help-block">{{___( "You can type requirements below, 1 per line, that you want to be sub-requirements of this one you are currently creating. Empty lines will be stripped automatically." )}}</span>

          <textarea class="form-control input-lg" id="requirement-children" ng-model="requirement.children" placeholder="{{___("Paste or type project sub-requirements here.")}}" rows="10"></textarea>

        </div>

        <br />

        <button type="button" class="btn btn-lg btn-success" ng-click="save()">{{___( "Save, &amp; New" )}}</button> &nbsp;
        <button type="button" class="btn btn-lg btn-primary" ng-click="saveClose()">{{___( "Save, &amp; Close" )}}</button>

      </form>

    </div>

  </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/EditRequirementCtrl.js"></script>
@stop
