@extends('index')

@section('title')
{{$project->title}} - {{___( "Dashboard" )}}
@stop

@section('content')

  <div class="row-fluid">

    @include('navs.project-manage', [ 'active' => 'dashboard', 'project_id' => $project->id ])

    <div class="col-lg-10 main-content">

      <div class="heading-cell">
        <h2>{{$project->title}} - {{___( "Dashboard" )}}</h2>
      </div>

    </div>

  </div>
    
@stop

@section('javascript')
@stop
