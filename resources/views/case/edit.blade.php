@extends('index')

@section('title')
{{$project->title}} - {{___( "Edit Test Case" )}}
@stop

@section('content')

  <div layout="row">

    @include('navs.project-manage', [ 'active' => 'cases', 'project_id' => $project->id ])

    <div flex="80" class="main-content" ng-controller="EditCaseCtrl">

      <div class="heading-cell">
        <h2>{{$project->title}} - {{___( "Edit Test Case" )}}</h2>
      </div>

      <form class="form slim-form" role="form" method="post" action="">

        <input type="hidden" id="project_id" value="{{$project->id}}" />
        <input type="hidden" id="case_id" value="{{$case->id}}" />

        <div class="form-group">

          <label for="case-title" class="field-required">{{___( "Title" )}}</label>

          <input type="text" class="form-control input-lg" id="case-title" ng-model="case.title" />

        </div>

        <div class="form-group">

          <label for="case-instructions">{{___( "Instructions" )}}</label>

          <span class="help-block">{{___( "Describe to the user, what they should do to reproduce the desired outcome." )}}</span>

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

          <span class="help-block">{{___( "Have any extra information that should accompany this test case? Enter it here." )}}</span>

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
  <script src="/js/controllers/EditCaseCtrl.js"></script>
@stop
