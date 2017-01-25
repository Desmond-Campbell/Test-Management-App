@extends('index')

@section('title')
{{$project->title}} - {{___( "Add Test Cases" )}}
@stop

@section('content')

  <div class="row-fluid">

    @include('navs.project-manage', [ 'active' => 'cases', 'project_id' => $project->id ])

    <div class="col-lg-10 main-content" ng-controller="NewCaseCtrl">

      <div class="heading-cell">
        <h2>{{$project->title}} - {{___( "Add Test Cases" )}}</h2>
      </div>

      <form class="form slim-form" role="form" method="post" action="">

        <input type="hidden" id="project_id" value="{{$project->id}}" />

        <div class="alert alert-info">
          {{___( "A test case is a unit of testing that describes an action and its outcome. It's effectively an action that should reproduce desired results from a small set of related features, or a single feature. E.g., if you're building a social network, a simple test case could be: User log in." )}}
        </div>

        <div class="form-group">

          <label for="case-title" class="field-required">{{___( "Title" )}}</label>

          <md-input-container>
            <label>Title</label>
            <input class="form-control input-lg" id="case-title" ng-model="case.title" />
          </md-input-container>

        </div>

        <div class="form-group">

          <label for="case-instructions">{{___( "Instructions" )}}</label>

          <span class="help-text">{{___( "Describe to the user, what they should do to reproduce the desired outcome." )}}</span>

          <textarea class="form-control input-lg" id="case-instructions" ng-model="case.instructions" placeholder="{{___("Enter instructions here (optional).")}}" rows="5"></textarea>

        </div>

        <md-autocomplete
          ng-disabled="isDisabled"
          ng-model="case.section_name"
          md-no-cache="noCache"
          md-selected-item="selectedItem"
          md-search-text-change="searchTextChange(searchText)"
          md-search-text="searchText"
          md-selected-item-change="selectedItemChange(item)"
          md-items="item in querySearch(searchText)"
          md-item-text="item.name"
          md-min-length="0"
          placeholder="{{___( "Choose a section for this test case. Default section is Main." )}}">
          <md-item-template>
            <span md-highlight-text="searchText" md-highlight-flags="^i">@{{item.name}}</span>
          </md-item-template>
        </md-autocomplete>

        <div class="form-group">

          <label for="case-notes">{{___( "Notes" )}}</label>

          <span class="help-text">{{___( "Have any extra information that should accompany this test case? Enter it here." )}}</span>

          <textarea class="form-control input-lg" id="case-notes" ng-model="case.notes" placeholder="{{___("Enter your notes here (optional).")}}" rows="5"></textarea>

        </div>

        <br />

        <button type="button" class="btn btn-lg btn-success" ng-click="save()">{{___( "Save, &amp; New" )}}</button> &nbsp;
        <button type="button" class="btn btn-lg btn-primary" ng-click="saveClose()">{{___( "Save, &amp; Close" )}}</button>

      </form>

    </div>

  </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/NewCaseCtrl.js"></script>
@stop
