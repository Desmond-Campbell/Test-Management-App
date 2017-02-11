<?php

namespace App\Http\Controllers;

use App\Projects;
use App\Suites;
use App\Files;
use App\Scenarios;
use App\Cases;
use App\Steps;
use App\Police;
use App\Activities;
use App\Search;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class SearchController extends Controller
{

  public function __construct( Request $r )
  {

    if ( $r->input( 'request-type' ) == 'full-template' ) {

      Config::set( 'pageconfig', 'full-template' );
      Config::set( 'hidefull', true );

    }

  }

  public function index( Request $r ) {

    $project_id = $r->route( 'project_id' );

    $project = Projects::find( $project_id );

    if ( !$project ) return redirect( '/projects' );

    $results = [];
    $project_id = (int) $r->route( 'project_id' );
    $query = trim( $r->input( 'q' ) );

    if ( $query ) $results = Search::search( $query, $project_id );

    return view( 'search.index', compact( 'project', 'results' ) );

  }

  public function getObject( Request $r ) {

    $project_id = $r->route( 'project_id' );
    $id = $r->route( 'id' );
    $object_type = $r->route( 'object_type' );
    $url = '';

    switch ( $object_type ):

      case 'test_suites':

        $object = Suites::find ( $id );

        if ( $object_type ) $url = 'suites?suite_id=' . $id;

      break;

      case 'test_scenarios':

        $object = Scenarios::find( $id );

        if ( $object ) $url = 'suites?suite_id=' . $object->suite_id . '&scenario_id=' . $id;

      break;

      case 'test_cases':

        $object = Cases::find( $id );

        if ( $object ) $url = 'suites/' . $object->suite_id . '/edit-case/' . $id;

      break;

      default:

        $url = '';

      break;

    endswitch;

    return redirect( '/projects/' . $project_id . '/' . $url );

  }

}
