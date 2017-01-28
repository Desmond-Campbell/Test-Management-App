@extends('index-full')

@section('title')
{{___( "Projects" )}}
@stop

@section('main')

    <div class="main-content" ng-controller="ProjectListCtrl">

      <div class="heading-cell">
        <h2>{{___( "Projects" )}}</h2>
      </div>

      <br />

      <button class="btn btn-sm btn-success">&nbsp; <i class="fa fa-plus"></i> &nbsp; Create a Project &nbsp;</button>

      <br />

      <ul class="grid-list project-list">

        <li ng-repeat="p in projects" md-white-frame="1">
        
          <md-card>
            <md-card-title>
              <md-card-title-text>
                <span class="grid-headline">@{{p.title}}</span>
                <p class="grid-subhead">

                  @{{p.description}} <br />

                  Created @{{p.created_at}}
                </p>
              </md-card-title-text>
              <md-card-title-media>
                <div class="md-media-sm card-media">
                  <img src="/img/icon2.png" />
                </div>
              </md-card-title-media>
            </md-card-title>
            <md-card-actions layout="row" layout-align="center">
              <a href="/projects/@{{p.id}}" class="btn btn-sm btn-default">&nbsp; <i class="fa fa-paper-plane"></i> &nbsp; {{___( "Select" ) }} &nbsp;</a>
            </md-card-actions>
          </md-card>

        </li>

        <li ng-show="projects.length < 1">
          <md-card>
            <md-card-title>
              <md-card-title-text>
                <span class="md-headline"></span>
                <span class="md-subhead"></span>
              </md-card-title-text>
              <md-card-title-media>
                <div class="md-media-sm card-media"></div>
              </md-card-title-media>
            </md-card-title>
            <md-card-actions layout="row" layout-align="end center">
              <md-button></md-button>
              <md-button></md-button>
            </md-card-actions>
          </md-card>
        </li>

        <li ng-show="projects.length < 2">
          <md-card>
            <md-card-title>
              <md-card-title-text>
                <span class="md-headline"></span>
                <span class="md-subhead"></span>
              </md-card-title-text>
              <md-card-title-media>
                <div class="md-media-sm card-media"></div>
              </md-card-title-media>
            </md-card-title>
            <md-card-actions layout="row" layout-align="end center">
              <md-button></md-button>
              <md-button></md-button>
            </md-card-actions>
          </md-card>
        </li>

      </ul>

    </div>
    
@stop

@section('javascript')
  <script src="/js/controllers/ProjectListCtrl.js"></script>
@stop
