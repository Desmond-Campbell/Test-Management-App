<?php

namespace App\Http\Controllers;

use App\Projects;
use App\Suites;
use App\Files;
use App\Scenarios;
use App\Cases;
use App\Steps;
use App\Search;
use App\Police;
use App\Activities;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class SuiteController extends Controller
{

  public function __construct( Request $r )
  {

    if ( $r->input( 'request-type' ) == 'full-template' ) {

      Config::set( 'pageconfig', 'full-template' );
      Config::set( 'hidefull', true );

    }

    \App\Tracker::track( $r->all() );

  }

  public function index( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'project_id' => $id, 
              'keystring' => 'projects.suites.view_suites', 
              'return' => $r->input( 'format' ) == 'json' ] );

    ////////////////////////////////////////////

    $project = Projects::find( $id );

    if ( $r->input( 'format') == 'json' ) {

      $suites = Suites::where( 'project_id', $id )->get();

      if ( $r->input( 'request-type') == 'namesonly' ) {

        $output = [];

        foreach ( $suites as $suite ) {

          if ( block( 'suites.view_all_suites', $id ) ) {

            if ( $suite->user_id == get_user_id() ) $output[] = $suite->name;

          } else {

            $output[] = $suite->name;

          }

        }

        return response()->json( [ 'suites' => $output ] );

      }

      $filtered_suites = [];

      foreach ( $suites as $suite ) {

        if ( block( 'suites.view_all_suites', $id ) ){

          if ( $suite->user_id == get_user_id() ) $filtered_suites[] = $suite;

        } else {

          $filtered_suites[] = $suite;

        }

      }

      return response()->json( [ 'suites' => $filtered_suites ] );

    } else {

      if ( !$project ) return redirect( '/projects' );

    }

    $suite_id = $r->input( 'suite_id' );

    return view( 'suite.index', compact( 'project', 'suite_id' ) );

  }

  public function newSuite( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.suites.create_suite', 'project_id' => $id ] );

    $project = Projects::find( $id );

    if ( !$project ) return redirect( '/projects' );

    return view( 'suite.new-suite', compact( 'project' ) );

  }

  public function createSuite( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.suites.create_suite', 'project_id' => $id, 'return' => 1 ] );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $name = $r->input( 'name' );
    $copy = $r->input( 'copy' );
    $description = $r->input( 'description' );
    $err = null;

    if ( !$name ) {

      $err = [ 'errors' => ___( 'Please enter a name for this suite.' ) ];

    } else {

      $count = Suites::where( 'project_id', $id )->where( 'name', $name )->count();

      if ( $count > 0 ) {

        $err = [ 'errors' => ___( 'The name you entered is already being used for a test suite in this project.' ) ];

      }

    }

    if ( $err ) {

      $result = $err;

    } else {

      $user_id = get_user_id();
 
      $newsuite = [
                  'name'          => $name,
                  'project_id'    => $id,
                  'user_id'    => $user_id,
                  'description'   => $description
                ];

      $result_id = Suites::create( $newsuite )->id;

      if ( $copy ) {

        $source = Suites::where( 'project_id', $id )->where( 'name', $copy )->first();

        if ( $source ) {

          // copy scenarios, which should cascade copy cases

          $scenarios = Scenarios::where( 'suite_id', $source->id )->get();

          foreach ( $scenarios as $s ) {

            Scenarios::copy( [ 'source' => $s->id, 'destination' => $result_id ] );

          }

        }

      }

      $result = [ 'success' => true, 'result_id' => $result_id ];

      $filter_hash = sha1( "create_suite.$name." . date( 'Y-m-d' ) );
      $activity_values = [ 'name' => $name ];

      $newactivity = [
                        'project_id'    => $id,
                        'object_type'   => 'create_suite',
                        'object_id'     => $result_id,
                        'user_id'       => $user_id,
                        'values'        => json_encode( $activity_values ),
                        'filter_hash'   => $filter_hash
                      ];

      Activities::create( $newactivity );

      Search::foil( [ 'object_type' => 'test_suites', 
                      'object_name' => $name, 
                      'project_id' => $id, 
                      'object_id' => $result_id ] );

    }

    return response()->json( $result );

  }

  public function editSuite( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.update_suites' ] );

    $project = Projects::find( $id );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return view('blocked');

    if ( $suite->project_id != $id ) return view('blocked');
    
    return view( 'suite.edit-suite', compact( 'project', 'suite' ) );

  }

  public function getSuite( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.view_suites', 'return' => 1 ] );

    $suite = Suites::find( $suite_id );

    if ( $suite ) {

      if ( $suite->project_id != $id ) 
        return response()->json( [ 'errors' => ___( 'Requested test suite not found on specified project.' ) ] );
    
    }

    return response()->json( [ 'suite' => $suite, 'id' => $suite_id ] );

  }

  public function updateSuite( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.suites.update_suites', 'project_id' => $id, 'return' => 1 ] );

    $suite_id = $r->route( 'suite_id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $name = $r->input( 'name' );
    $description = $r->input( 'description' );

    $err = null;

    if ( !$name ) {

      $err = [ 'errors' => ___( 'Please enter a title for this test scenario.' ) ];

    } else {

      $count = Suites::where( 'id', '<>', $suite_id )->where( 'name', $name )->count();

      if ( $count > 0 ) {

        $err = [ 'errors' => ___( 'The name you entered is already being used in this test project.' ) ];

      }

    }

    if ( $err ) {

      $result = $err;

    } else {

      $changes = [
                  'name'          => $name,
                  'description'   => $description
                ];

      $suite = Suites::find( $suite_id );

      $user_id = get_user_id();

      $filter_hash = sha1( "update_suite.$suite_id." . date( 'Y-m-d' ) );
      $activity_values = [ 'old' => [], 'new' => [] ];
      $activity_values['old']['name'] = $suite->name;
      $activity_values['old']['description'] = $suite->description;
      
      $newactivity = [
                        'project_id'    => $id,
                        'object_type'   => 'update_suite',
                        'object_id'     => $suite_id,
                        'user_id'       => $user_id,
                        'values'        => Activities::prepareValues( $activity_values ),
                        'filter_hash'   => $filter_hash
                      ];

      Activities::create( $newactivity );

      $suite->update( $changes );

      Search::foil( [ 'object_type' => 'test_suites', 
                      'object_name' => $name, 
                      'project_id' => $id, 
                      'object_id' => $suite_id ] );

      $changes['id'] = $suite_id;

      $result = [ 'success' => true, 'result' => $changes ];

    }

    return response()->json( $result );

  }

  public function deleteSuite( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.delete_suite', 'return' => 1 ] );

    $project = Projects::find( $id );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return [ 'errors' => ___( 'Suite not found.' ) ];;

    if ( $suite->project_id != $id ) return [ 'errors' => ___( 'Suite not found.' ) ];;

    $user_id = get_user_id();

    if ( block( 'suites.delete_all_suites', $id ) ) {

      if ( $suite->user_id != $user_id ) {

        return [ 'errors' => ___( "You are not allowed to delete test suites by others." ) ];

      }

    }

    $filter_hash = sha1( "delete_suite.$suite_id." . date( 'Y-m-d' ) );
    $activity_values = [ 'name' => $suite->name ];

    $newactivity = [
                      'project_id'    => $id,
                      'object_type'   => 'delete_suite',
                      'object_id'     => $suite_id,
                      'user_id'       => $user_id,
                      'values'        => json_encode( $activity_values ),
                      'filter_hash'   => $filter_hash
                    ];

    Activities::create( $newactivity );

    $suite->delete();
    $children = Scenarios::where( 'suite_id', $suite_id )->get();
    
    foreach ( $children as $c ) {

      Search::foil( [ 'object_type' => 'test_scenarios', 
                      'project_id' => $id, 
                      'object_id' => $c->id ] );
      $c->delete();

    }

    $grand_children = Cases::where( 'suite_id', $suite_id )->get();
    
    foreach ( $grand_children as $g ) {

      Search::foil( [ 'object_type' => 'test_cases', 
                      'project_id' => $id, 
                      'object_id' => $g->id ] );
      $g->delete();

    }

    Search::unseed( [ 'object_type' => 'test_suites', 
                      'project_id' => $id, 
                      'object_id' => $suite_id ] );

    $result = [ 'success' => true ];

    return response()->json( $result );

  }

  public function getScenarios( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.view_scenarios', 'return' => 1 ] );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return response()->json( [ 'errors' => ___( "Requested test scenarios not found." ) . ee( 'invalid_test_suite' ) ] );
    
    if ( $suite->project_id != $id ) return response()->json( [ 'errors' => ___( "Requested test scenarios not found (invalid project)." ) ] );

    if ( block( 'suites.view_all_scenarios', $id ) ) {

      $scenarios = Scenarios::where( 'suite_id', $suite_id )->where( 'user_id', get_user_id() )->get();

    } else {

      $scenarios = Scenarios::where( 'suite_id', $suite_id )->get();

    }

    return response()->json( [ 'scenarios' => $scenarios ] );

  }

  public function getScenario( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );
    $scenario_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.view_scenarios', 'return' => 1 ] );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return response()->json( [ 'errors' => ___( "Requested test scenario not found." ) . ee( 'invalid_test_suite' ) ] );
    
    if ( $suite->project_id != $id ) return response()->json( [ 'errors' => ___( "Requested test scenario not found." ) . ee( 'invalid_project' ) ] );

    $scenario = Scenarios::find( $scenario_id );

    if ( $scenario ) {

      if ( $scenario->project_id != $id || $scenario->suite_id != $suite_id ) 
        return response()->json( [ 'errors' => ___( 'Requested scenario not found.' ) ] );
    
    }

    return response()->json( [ 'scenario' => $scenario ] );

  }

  public function createScenario( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );

    police( [ 'keystring' => 'projects.suites.create_scenario', 'project_id' => $id, 'return' => 1 ] );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return [ 'errors' => ___( 'Suite not found.' ) ];

    $name = $r->input( 'name' );
    $err = null;

    if ( !$name ) {

      $err = [ 'errors' => ___( 'Please enter a name/heading for this scenario.' ) ];

    } else {

      $count = Scenarios::where( 'suite_id', $suite_id )->where( 'name', $name )->count();

      if ( $count > 0 ) {

        $err = [ 'errors' => ___( 'The name you entered is already being used for a scenario in this test suite.' ) ];

      }

    }

    if ( $err ) {

      $result = $err;

    } else {

      $user_id = get_user_id();

      $newscenario = [
                      'name'          => $name,
                      'project_id'    => $id,
                      'suite_id'      => $suite_id,
                      'user_id'      => $user_id
                    ];

      $result_id = Scenarios::create( $newscenario )->id;

      Suites::find( $suite_id )->update( [ 'children' => DB::raw( 'children + 1' ) ] );

      $filter_hash = sha1( "create_scenario.$name." . date( 'Y-m-d' ) );
      $activity_values = [ 'name' => $name ];

      $newactivity = [
                        'project_id'    => $id,
                        'object_type'   => 'create_scenario',
                        'object_id'     => $result_id,
                        'user_id'       => $user_id,
                        'values'        => json_encode( $activity_values ),
                        'filter_hash'   => $filter_hash
                      ];

      Activities::create( $newactivity );

      Search::foil( [ 'object_type' => 'test_scenarios', 
                      'object_name' => $name, 
                      'project_id' => $id, 
                      'object_id' => $result_id ] );

      $result = [ 'success' => true, 'result_id' => $result_id ];

    }

    return response()->json( $result );

  }

  public function editScenario( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );
    $scenario_id = $r->route( 'scenario_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.update_scenarios' ] );

    $project = Projects::find( $id );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return view('blocked');


    if ( $suite->project_id != $id ) return view('blocked');
    
    $scenario = Scenarios::find( $scenario_id );

    if ( !$scenario ) return view('blocked');

    if ( $scenario->suite_id != $suite_id || $scenario->project_id != $id ) return view('blocked');

    $suite_params = '?suite_id=' . $suite_id . '&scenario_id=' . $scenario->id;

    return view( 'suite.edit-scenario', compact( 'project', 'scenario', 'suite', 'suite_params' ) );

  }

  public function updateScenario( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.suites.update_scenarios', 'project_id' => $id, 'return' => 1 ] );

    $suite_id = $r->route( 'suite_id' );
    $scenario_id = $r->route( 'scenario_id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $scenario = Scenarios::find( $scenario_id );

    if ( !$scenario ) return [ 'errors' => ___( 'Scenario not found.' ) ];

    $name = $r->input( 'name' );
    $description = $r->input( 'description' );

    $err = null;

    if ( !$name ) {

      $err = [ 'errors' => ___( 'Please enter a title for this test scenario.' ) ];

    } else {

      $count = Scenarios::where( 'suite_id', $suite_id )->where( 'id', '<>', $scenario_id )->where( 'name', $name )->count();

      if ( $count > 0 ) {

        $err = [ 'errors' => ___( 'The name you entered is already being used in this test suite.' ) ];

      }

    }

    if ( $err ) {

      $result = $err;

    } else {

      $changes = [
                  'name'          => $name,
                  'description'   => $description
                ];

      $user_id = get_user_id();

      $filter_hash = sha1( "update_scenario.$scenario_id." . date( 'Y-m-d' ) );
      $activity_values = [ 'old' => [], 'new' => [ 'name' => $name ] ];
      $activity_values['old']['name'] = $scenario->name;
      $activity_values['old']['description'] = $scenario->description;
      
      $newactivity = [
                        'project_id'    => $id,
                        'object_type'   => 'update_scenario',
                        'object_id'     => $scenario_id,
                        'user_id'       => $user_id,
                        'values'        => Activities::prepareValues( $activity_values ),
                        'filter_hash'   => $filter_hash
                      ];

      Activities::create( $newactivity );

      $scenario->update( $changes );

      Search::foil( [ 'object_type' => 'test_scenarios', 
                      'object_name' => $name, 
                      'project_id' => $id, 
                      'object_id' => $scenario_id ] );

      $changes['id'] = $scenario_id;

      $result = [ 'success' => true, 'result' => $changes ];

    }

    return response()->json( $result );

  }

  public function deleteScenario( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );
    $scenario_id = $r->route( 'scenario_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.delete_scenario', 'return' => 1 ] );

    $project = Projects::find( $id );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return [ 'errors' => ___( 'Suite not found.' ) ];;

    if ( $suite->project_id != $id ) return [ 'errors' => ___( 'Suite not found.' ) ];;

    $scenario = Scenarios::find( $scenario_id );

    if ( !$scenario ) return [ 'errors' => ___( 'Scenario not found.' ) ];
    
    if ( $suite_id != $scenario->suite_id ) return [ 'errors' => ___( 'Scenario not found.' ) ];

    $user_id = get_user_id();

    if ( block( 'suites.delete_all_scenarios', $id ) ) {

      if ( $scenario->user_id != $user_id ) {

        return [ 'errors' => ___( "You are not allowed to delete scenarios created by others." ) ];

      }

    }

    $filter_hash = sha1( "delete_scenario.$scenario_id." . date( 'Y-m-d' ) );
    $activity_values = [ 'name' => $scenario->name ];

    $newactivity = [
                      'project_id'    => $id,
                      'object_type'   => 'delete_scenario',
                      'object_id'     => $scenario_id,
                      'user_id'       => $user_id,
                      'values'        => json_encode( $activity_values ),
                      'filter_hash'   => $filter_hash
                    ];

    Activities::create( $newactivity );

    $scenario->delete();
    $children = Cases::where( 'scenario_id', $scenario_id )->get();
    $suite->update( [ 'grand_children' => DB::raw( "grand_children - " . count( $children->count() ) ), 'children' => DB::raw( 'children - 1' ) ] );

    foreach ( $children as $c ) {

      Search::unseed( [ 'object_type' => 'test_cases', 
                      'project_id' => $id, 
                      'object_id' => $c->id ] );
      $c->delete();

    }

    Search::unseed( [ 'object_type' => 'test_scenarios', 
                      'project_id' => $id, 
                      'object_id' => $scenario_id ] );

    $result = [ 'success' => true ];

    return response()->json( $result );

  }

  public function uploadScenarioFile( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );
    $scenario_id = $r->route( 'scenario_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.update_scenarios', 'return' => 1 ] );

    $project = Projects::find( $id );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return [ 'errors' => ___( 'Suite not found.' ) ];;

    if ( $suite->project_id != $id ) return [ 'errors' => ___( 'Suite not found.' ) ];;

    $scenario = Scenarios::find( $scenario_id );

    if ( !$scenario ) return [ 'errors' => ___( 'Scenario not found.' ) ];
    
    if ( $suite_id != $scenario->suite_id ) return [ 'errors' => ___( 'Scenario not found.' ) ];

    $user_id = get_user_id();
    $files = [];

    foreach ( $_FILES as $file ) {

      $variables = json_encode( [ 'suite_id' => $suite_id ] );

      $args = [ 
                'project_id'    => $id,
                'object_id'   => $scenario_id,
                'variables'     => $variables,
                'network_id'    => \App\Options::get( 'network_id' ),
                ];

      $file_id = Files::store( $file, $args );

      $_files = $scenario->files;
      if ( !$_files ) $_files = '[]';

      $files = json_decode( $_files );
      $files[] = $file_id;

      $scenario = Scenarios::find( $scenario_id );
      $scenario->update( [ 'files' => json_encode( $files ) ] );

      $filter_hash = sha1( "upload_scenario_file.$scenario_id." . date( 'Y-m-d' ) );
      $activity_values = [ 'name' => $scenario->name, 'object_id' => $scenario_id ];

      $newactivity = [
                        'project_id'    => $id,
                        'object_type'   => 'upload_scenario_file',
                        'object_id'     => $file_id,
                        'user_id'       => $user_id,
                        'values'        => json_encode( $activity_values ),
                        'filter_hash'   => $filter_hash
                      ];

      Activities::create( $newactivity );

    }

    $result = [ 'success' => true, 'files' => $files ];

    return response()->json( $result );

  }

  public function getScenarioFiles( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );
    $scenario_id = $r->route( 'scenario_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.view_scenarios', 'return' => 1 ] );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return response()->json( [ 'errors' => ___( "Requested test scenario not found." ) . ee( 'invalid_test_suite' ) ] );
    
    if ( $suite->project_id != $id ) return response()->json( [ 'errors' => ___( "Requested test scenario not found." ) . ee( 'invalid_project' ) ] );

    $scenario = Scenarios::find( $scenario_id );

    if ( $scenario ) {

      if ( !$scenario->files || $scenario->files == '[]' ) return response()->json( [] );

      $fileIds = json_decode( $scenario->files );

      $files = Files::whereIn( 'id', $fileIds )->get();

      return response()->json( [ 'files' => $files ] );
    
    }

    return response()->json( [ 'errors' => ___( "Requested test scenario not found." ) ] );

  }

  public function deleteScenarioFile( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );
    $scenario_id = $r->route( 'scenario_id' );
    $file_id = $r->route( 'file_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.update_scenarios', 'return' => 1 ] );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return response()->json( [ 'errors' => ___( "Requested test scenario not found." ) . ee( 'invalid_test_suite' ) ] );
    
    if ( $suite->project_id != $id ) return response()->json( [ 'errors' => ___( "Requested test scenario not found." ) . ee( 'invalid_project' ) ] );

    $scenario = Scenarios::find( $scenario_id );

    if ( $scenario ) {

      if ( !$scenario->files || $scenario->files == '[]' ) return response()->json( [ 'errors' => ___( "Well, the file you are trying to delete does not exist. Hmmmm." ) ] );

      $fileIds = json_decode( $scenario->files );
      $fileIdsUpdated = [];

      foreach ( $fileIds as $fileid ) {

        if ( $fileid == $file_id ) {

          $file = Files::find( $file_id );

          if ( $file ) {

            $path = $file->path;
            unlink( $path );
            $file->delete;

          }

        } else {

          $fileIdsUpdated[] = $fileid;

        }

      }

      $scenario->update( [ 'files' => json_encode( $fileIdsUpdated ) ] );

      return response()->json( [ 'success' => true ] );
    
    }

    return response()->json( [ 'errors' => ___( "Requested test scenario not found." ) ] );

  }

  public function getCases( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );
    $scenario_id = $r->route( 'scenario_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.view_cases', 'return' => 1 ] );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return response()->json( [ 'errors' => ___( "Requested test cases not found." ) . ee( 'invalid_test_suite' ) ] );

    if ( $suite->project_id != $id ) return response()->json( [ 'errors' => ___( "Requested test cases not found." ) . ee( 'invalid_project' ) ] );
    
    $scenario = Scenarios::find( $scenario_id );

    if ( !$scenario ) return response()->json( [ 'errors' => ___( "Requested test cases not found." ) ] );

    if ( $scenario->suite_id != $suite_id || $scenario->project_id != $id ) return response()->json( [ 'errors' => ___( "Requested test cases not found." ) . ee( 'invalid_test_suite_or_project' ) ] );

    $user_id = get_user_id();

    if ( block( 'suites.view_all_cases', $id ) ) {

      $cases = Cases::where( 'scenario_id', $scenario_id )->where( 'user_id', $user_id )->get();

    } else {

      $cases = Cases::where( 'scenario_id', $scenario_id )->get();

    }

    return response()->json( [ 'cases' => $cases ] );

  }

  public function getCase( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );
    $case_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.view_cases', 'return' => 1 ] );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return response()->json( [ 'errors' => ___( "Requested test case not found." ) . ee( 'invalid_test_suite' ) ] );

    if ( $suite->project_id != $id ) return response()->json( [ 'errors' => ___( "Requested test case not found." ) . ee( 'invalid_project' ) ] );
    
    $case = Cases::find( $case_id );

    if ( !$case ) return response()->json( [ 'errors' => ___( "Requested test case not found." ) ] );

    if ( $case->suite_id != $suite_id || $case->project_id != $id ) return response()->json( [ 'errors' => ___( "Requested test case not found." ) . ee( 'invalid_test_suite_or_project' ) ] );

    return response()->json( [ 'case' => $case ] );

  }

  public function createCase( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );
    $scenario_id = $r->route( 'scenario_id' );

    police( [ 'keystring' => 'projects.suites.create_case', 'project_id' => $id, 'return' => 1 ] );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return [ 'errors' => ___( 'Suite not found.' ) ];

    $scenario = Scenarios::find( $scenario_id );

    if ( !$scenario ) return [ 'errors' => ___( 'Scenario not found.' ) ];

    $name = $r->input( 'name' );
    $err = null;

    if ( !$name ) {

      $err = [ 'errors' => ___( 'Please enter a name/heading for this test case. You will be able to add more information after you create it.' ) ];

    } else {

      $count = Cases::where( 'scenario_id', $scenario_id )->where( 'name', $name )->count();

      if ( $count > 0 ) {

        $err = [ 'errors' => ___( 'The name you entered is already being used for a test case in the selected test scenario.' ) ];

      }

    }

    if ( $err ) {

      $result = $err;

    } else {

      $user_id = get_user_id();

      $newcase = [
                      'name'          => $name,
                      'project_id'    => $id,
                      'suite_id'      => $suite_id,
                      'scenario_id'      => $scenario_id,
                      'user_id'      => $user_id
                    ];

      $result_id = Cases::create( $newcase )->id;

      $filter_hash = sha1( "create_test_case.$name." . date( 'Y-m-d' ) );
      $activity_values = [ 'name' => $name ];

      $newactivity = [
                        'project_id'    => $id,
                        'object_type'   => 'create_test_case',
                        'object_id'     => $result_id,
                        'user_id'       => $user_id,
                        'values'        => json_encode( $activity_values ),
                        'filter_hash'   => $filter_hash
                      ];

      Activities::create( $newactivity );

      Search::foil( [ 'object_type' => 'test_cases', 
                      'object_name' => $name, 
                      'project_id' => $id, 
                      'object_id' => $result_id ] );

      // Adjust case count on scenario

      Scenarios::find( $scenario_id )->update( [ 'children' => DB::raw( 'children + 1' ) ] );
      Suites::find( $suite_id )->update( [ 'grand_children' => DB::raw( 'grand_children + 1' ) ] );

      $newstep = [ 'project_id'     => $id, 
                    'user_id'       => get_user_id(), 
                    'suite_id'      => $suite_id, 
                    'scenario_id'   => $scenario_id, 
                    'case_id'       => $result_id,
                    'name'          => ___( "There must be at least 1 step on a test case. This is a default that you can edit or remove." ),
                    'item_position' => 1
                  ];

      Steps::create( $newstep );

      $result = [ 'success' => true, 'result_id' => $result_id ];

    }

    return response()->json( $result );

  }

  public function editCase( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );
    $case_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.update_cases' ] );

    $project = Projects::find( $id );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return view('blocked');

    if ( $suite->project_id != $id ) return view('blocked');
    
    $case = Cases::find( $case_id );

    if ( !$case ) return view('blocked');

    if ( $case->suite_id != $suite_id || $case->project_id != $id ) return view('blocked');

    $scenario = Scenarios::find( $case->scenario_id );

    if ( !$scenario ) return view('blocked');
    
    if ( $scenario->project_id != $id || $scenario->project_id != $case->project_id ) return view('blocked');

    $suite_params = '?suite_id=' . $suite_id . '&scenario_id=' . $scenario->id;

    return view( 'suite.edit-case', compact( 'project', 'case', 'suite', 'suite_params' ) );

  }

  public function updateCase( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.suites.update_cases', 'project_id' => $id, 'return' => 1 ] );

    $suite_id = $r->route( 'suite_id' );
    $case_id = $r->route( 'id' );

    $project = Projects::find( $id );
    $case = Cases::find( $case_id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];
    if ( !$case ) return [ 'errors' => ___( 'Case not found.' ) ];

    $name = $r->input( 'name' );
    $description = $r->input( 'description' );
    $fail_criteria = $r->input( 'fail_criteria' );
    $pass_criteria = $r->input( 'pass_criteria' );
    $err = null;

    if ( !$name ) {

      $err = [ 'errors' => ___( 'Please enter a title for this test case.' ) ];

    } else {

      $count = Cases::where( 'scenario_id', $case->scenario_id )->where( 'id', '<>', $case_id )->where( 'name', $name )->count();

      if ( $count > 0 ) {

        $err = [ 'errors' => ___( 'The name you entered is already being used in this test scenario.' ) ];

      }

    }

    if ( $err ) {

      $result = $err;

    } else {

      $changes = [
                  'name'            => $name,
                  'description'     => $description,
                  'pass_criteria'   => $pass_criteria,
                  'fail_criteria'   => $fail_criteria
                ];

      $case = Cases::find( $case_id );

      $user_id = get_user_id();

      $filter_hash = sha1( "update_case.$case_id." . date( 'Y-m-d' ) );
      $activity_values = [ 'old' => [], 'new' => [] ];
      $activity_values['old']['name'] = $case->name;
      $activity_values['old']['description'] = $case->description;
      $activity_values['old']['pass_criteria'] = $case->pass_criteria;
      $activity_values['old']['fail_criteria'] = $case->fail_criteria;
      
      $newactivity = [
                        'project_id'    => $id,
                        'object_type'   => 'update_case',
                        'object_id'     => $case_id,
                        'user_id'       => $user_id,
                        'values'        => Activities::prepareValues( $activity_values ),
                        'filter_hash'   => $filter_hash
                      ];

      Activities::create( $newactivity );

      Search::foil( [ 'object_type' => 'test_cases', 
                      'object_name' => $name, 
                      'project_id' => $id, 
                      'object_id' => $case_id ] );

      $case->update( $changes );

      $changes['id'] = $case_id;

      $result = [ 'success' => true, 'result' => $changes ];

    }

    return response()->json( $result );

  }

  public function deleteCase( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );
    $scenario_id = $r->route( 'scenario_id' );
    $case_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.delete_case', 'return' => 1 ] );

    $project = Projects::find( $id );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return [ 'errors' => ___( 'Suite not found.' ) ];;

    if ( $suite->project_id != $id ) return [ 'errors' => ___( 'Suite not found.' ) ];;

    $scenario = Scenarios::find( $scenario_id );

    if ( !$scenario ) return [ 'errors' => ___( 'Scenario not found. ' ) ];
    
    if ( $scenario->suite_id != $suite_id ) return [ 'errors' => ___( 'Scenario not found.' ) ];;

    $case = Cases::find( $case_id );

    if ( !$case ) return [ 'errors' => ___( 'Case not found.' ) ];

    if ( $case->suite_id != $suite_id || $case->project_id != $id ) return [ 'errors' => ___( 'Case not found.' ) ];

    $user_id = get_user_id();

    if ( block( 'suites.delete_all_cases', $id ) ) {

      if ( $case->user_id != $user_id ) {

        return [ 'errors' => ___( "You are not allowed to delete test cases created by others." ) ];

      }

    }

    $filter_hash = sha1( "delete_case.$scenario_id." . date( 'Y-m-d' ) );
    $activity_values = [ 'name' => $case->name ];

    $newactivity = [
                      'project_id'    => $id,
                      'object_type'   => 'delete_case',
                      'object_id'     => $case_id,
                      'user_id'       => $user_id,
                      'values'        => json_encode( $activity_values ),
                      'filter_hash'   => $filter_hash
                    ];

    Activities::create( $newactivity );

    Search::unseed( [ 'object_type' => 'test_cases', 
                      'object_name' => $case->name, 
                      'project_id' => $id, 
                      'object_id' => $case_id ] );

    $case->delete();
    $scenario->update( [ 'children' => DB::raw( 'children - 1' ) ] );
    $suite->update( [ 'grand_children' => DB::raw( 'grand_children - 1' ) ] );

    $result = [ 'success' => true ];

    return response()->json( $result );

  }

  public function getSteps( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );
    $case_id = $r->route( 'case_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.view_cases', 'return' => 1 ] );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return response()->json( [ 'errors' => ___( "Requested test steps not found." ) . ee( 'invalid_test_suite' ) ] );

    if ( $suite->project_id != $id ) return response()->json( [ 'errors' => ___( "Requested test steps not found." ) . ee( 'invalid_project' ) ] );
    
    $case = Cases::find( $case_id );

    if ( !$case ) return response()->json( [ 'errors' => ___( "Requested test steps not found." ) ] );

    $scenario = Scenarios::find( $case->scenario_id );

    if ( !$scenario ) return response()->json( [ 'errors' => ___( "Requested test steps not found." ) ] );

    if ( $scenario->suite_id != $suite_id || $scenario->project_id != $id ) return response()->json( [ 'errors' => ___( "Requested test steps not found." ) . ee( 'invalid_test_suite_or_project' ) ] );

    $steps = Steps::where( 'case_id', $case_id )->orderBy('item_position', 'asc')->get();

    return response()->json( [ 'steps' => $steps ] );

  }

  public function saveSteps( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );
    $case_id = $r->route( 'case_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.update_cases', 'return' => 1 ] );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return response()->json( [ 'errors' => ___( "Requested test steps not found." ) . ee( 'invalid_test_suite' ) ] );

    if ( $suite->project_id != $id ) return response()->json( [ 'errors' => ___( "Requested test steps not found." ) . ee( 'invalid_project' ) ] );
    
    $case = Cases::find( $case_id );

    if ( !$case ) return response()->json( [ 'errors' => ___( "Requested test steps not found." ) ] );

    $scenario = Scenarios::find( $case->scenario_id );

    if ( !$scenario ) return response()->json( [ 'errors' => ___( "Requested test steps not found." ) ] );

    if ( $scenario->suite_id != $suite_id || $scenario->project_id != $id ) return response()->json( [ 'errors' => ___( "Requested test steps not found." ) . ee( 'invalid_test_suite_or_project' ) ] );

    $steps = $r->input( 'steps' );

    if ( !$steps ) $steps = [ 'name' => ___( "There must be at least 1 step on a test case. This is a default that you can edit or remove." ) ];

    if ( $steps ) {

      //Steps::where( 'case_id', $case_id )->delete();

      $i = 0;

      foreach ( $steps as $step ) {

        if ( !empty( $step['name'] ) ) {

          $newstep = [ 'project_id' => $id, 
                        'user_id' => get_user_id(), 
                        'suite_id' => $suite_id, 
                        'scenario_id' => $scenario->id, 
                        'case_id' => $case_id ];
          $newstep['name'] = $step['name'];
          $newstep['item_position'] = $i;

          if ( !empty( $step['id'] ) ) {

            Steps::find( $step['id'] )->update( $newstep );

          } else {

            Steps::create( $newstep );
          
          }

          $i++;

        }

      }

      $steps = Steps::where( 'case_id', $case_id )->orderBy('item_position', 'asc')->get();

      $user_id = get_user_id();

      $filter_hash = sha1( "update_steps.$case_id." . date( 'Y-m-d' ) );
      $activity_values = [ 'case_name' => $case->name ];

      $newactivity = [
                        'project_id'    => $id,
                        'object_type'   => 'update_steps',
                        'object_id'     => $case_id,
                        'user_id'       => $user_id,
                        'values'        => json_encode( $activity_values ),
                        'filter_hash'   => $filter_hash
                      ];

      Activities::create( $newactivity );

      return response()->json( [ 'steps' => $steps ] );

    }

  }

}
