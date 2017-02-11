@extends('index')

@section('title')
{{$project->title}} - {{___( "Search" )}}
@stop

@section('left-side')

  @include('navs.project-manage', [ 'project_id' => $project->id ])

@stop

@section('page-heading')
{{___( "Search Project" )}}
@stop

@section('main')

  <form method="get" action="/projects/{{$project->id}}/search" role="form" class="form-inline">

    @if ( !arg( $_REQUEST, 'q' ) )
    
    <div class="alert alert-info">

      {{ ___( "Enter some keywords in the search box at the top of the page." )}}

    </div>
    
    @else

    <div class="push-down">

      @if ( count( $results ) )

      <h5>

        {{___("Here are some item(s) that attached your search term.")}}
      
      </h5>

      <div class="push-down">

        <ol class="search-results">

          @foreach ( $results as $r )

            <li>
            
              <a href="/projects/{{$project->id}}{{\App\Search::getUrl( $r )}}" class="result-link">{{$r->object_name}}</a>
              <span class="result-type">
                [{{substr( ucwords( str_replace( '_', ' ', $r->object_type)), 0, strlen( $r->object_type ) - 1 )}}]
              </span>

            </li>

          @endforeach

        </ol>

      </div>

      @else

      <div class="alert alert-warning">

        {{ ___( "No results were found for your search term for this project." )}}

      </div>

      @endif

    </div>

    @endif

  </form>

@stop
