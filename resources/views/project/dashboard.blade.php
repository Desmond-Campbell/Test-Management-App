@extends('index')

@section('title')
{{$project->title}} - {{___( "Dashboard" )}}
@stop

@section('left-side')

  @include('navs.project-manage', [ 'active' => 'dashboard', 'project_id' => $project->id ])

@stop

@section('page-heading')
{{___( "Project Dashboard" )}}
@stop

@section('main')

  <div ng-controller="ProjectDashboardCtrl">

    <input type="hidden" id="project_id" value="{{$project->id}}" />
    
    <div layout="row">

	    <div flex="60">

	    	<h1 class="no-margin-top">Activities</h1>

	    	<div ng-show="!activities.length">

	    		{{___( "There are no acitivites on this project as yet." )}}

	    	</div>

	    	<div ng-show="activities.length > 0">

	    		<md-card ng-repeat="a in activities" layout-padding class="push-down activity-feed">

	    			<div ng-bind-html="a.content"></div>

	    			<div class="activity-date"><i class="fa fa-clock-o"></i> @{{a.record.created_at | relativeTime}}</div>

	    		</md-card>

	    	</div>

	    </div>

	    <div flex="5"></div>

	    <div flex class="hidden-xs">

	    	<md-content flex layout-padding md-white-frame>
	    		
	    		<h3 class="no-margin-top">Properties</h3>

	    		<ul class="box-list list-group">

					  <li class="list-group-item">
						  <div>
						    <strong>Date Created:</strong><br />
						    <small>{{"<?=$project->created_at;?>"}}</small>
						  </div>
						</li>

						<li class="list-group-item">
						  <div>
						    <strong>Created By:</strong><br />
						    <small>{{"<?=$project->user_id;?>"}}</small>
						  </div>
						</li>

						<li class="list-group-item">
						  <div>
						    <strong>Current Owner:</strong><br />
						    <small>{{"<?=$project->user_id;?>"}}</small>
						  </div>
						</li> 

					</ul>

					<h3 class="no-margin-top">Summary</h3>

	    		<ul class="box-list list-group">

					  <li class="list-group-item">
						  <div class="row">
						    <div class="col-md-8">
						    	<strong>Requirements</strong>
						    </div>
						    <div class="col-md-4">0</div>
						  </div>
						</li>

					  <li class="list-group-item">
						  <div class="row">
						    <div class="col-md-8">
						    	<strong>Test Suites</strong>
						    </div>
						    <div class="col-md-4">0</div>
						  </div>
						</li>

					  <li class="list-group-item">
						  <div class="row">
						    <div class="col-md-8">
						    	<strong>Files</strong>
						    </div>
						    <div class="col-md-4">0</div>
						  </div>
						</li>

					  <li class="list-group-item">
						  <div class="row">
						    <div class="col-md-8">
						    	<strong>Discussions</strong>
						    </div>
						    <div class="col-md-4">0</div>
						  </div>
						</li>

					  <li class="list-group-item">
						  <div class="row">
						    <div class="col-md-8">
						    	<strong>Active Test Runs</strong>
						    </div>
						    <div class="col-md-4">0</div>
						  </div>
						</li> 

					</ul>

	    	</md-content>

	    </div>

    </div>

  </div>

@stop

@section('javascript')
  <script src="/js/controllers/ProjectDashboardCtrl.js"></script>
@stop
