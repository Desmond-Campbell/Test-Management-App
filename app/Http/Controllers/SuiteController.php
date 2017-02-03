<?php

namespace App\Http\Controllers;

use App\Projects;
use App\Suites;
use App\Scenarios;
use App\Cases;
use App\Steps;
use App\Police;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class SuiteController extends Controller
{

  public function __construct( Request $r )
  {

    if ( $r->input( 'request-type' ) == 'full-template' ) Config::set( 'pageconfig', 'full-template' );

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

          $output[] = $suite->name;

        }

        return response()->json( [ 'suites' => $output ] );

      }

      return response()->json( [ 'suites' => $suites ] );

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

      $newsuite = [
                  'name'          => $name,
                  'project_id'    => $id,
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

    }

    return response()->json( $result );

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

  public function getScenarios( Request $r ) {

    $id = $r->route( 'project_id' );
    $suite_id = $r->route( 'suite_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.view_scenarios', 'return' => 1 ] );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return response()->json( [ 'errors' => ___( "Requested test scenarios not found." ) . ee( 'invalid_test_suite' ) ] );
    
    if ( $suite->project_id != $id ) return response()->json( [ 'errors' => ___( "Requested test scenarios not found (invalid project)." ) ] );

    $scenarios = Scenarios::where( 'suite_id', $suite_id )->get();

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

      $newscenario = [
                      'name'          => $name,
                      'project_id'    => $id,
                      'suite_id'      => $suite_id
                    ];

      $result_id = Scenarios::create( $newscenario )->id;

      Suites::find( $suite_id )->update( [ 'children' => DB::raw( 'children + 1' ) ] );

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

      Scenarios::find( $scenario_id )->update( $changes );

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
    
    if ( $suite->scenario_id != $scenario->id ) return [ 'errors' => ___( 'Scenario not found.' ) ];;

    $scenario->delete();
    $grand_children = Cases::where( 'scenario_id', $scenario_id );
    $suites->update( [ 'grand_children' => DB::raw( "grand_children - " . $grand_children->count() ), 'children' => DB::raw( 'children - 1' ) ] );
    $grand_children->delete();

    return response()->json( $result );

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

    $cases = Cases::where( 'scenario_id', $scenario_id )->get();

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

      $newcase = [
                      'name'          => $name,
                      'project_id'    => $id,
                      'suite_id'      => $suite_id,
                      'scenario_id'      => $scenario_id
                    ];

      $result_id = Cases::create( $newcase )->id;

      // Adjust case count on scenario

      Scenarios::find( $scenario_id )->update( [ 'children' => DB::raw( 'children + 1' ) ] );
      Suites::find( $suite_id )->update( [ 'grand_children' => DB::raw( 'grand_children + 1' ) ] );

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
                  'name'          => $name,
                  'description'   => $description
                ];

      Cases::find( $case_id )->update( $changes );

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

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.delete_cases', 'return' => 1 ] );

    $project = Projects::find( $id );

    $suite = Suites::find( $suite_id );

    if ( !$suite ) return [ 'errors' => ___( 'Suite not found.' ) ];;

    if ( $suite->project_id != $id ) return [ 'errors' => ___( 'Suite not found.' ) ];;

    $scenario = Scenarios::find( $scenario_id );

    if ( !$scenario ) return [ 'errors' => ___( 'Scenario not found.' ) ];
    
    if ( $suite->scenario_id != $scenario->id ) return [ 'errors' => ___( 'Scenario not found.' ) ];;

    $case = Cases::find( $case_id );

    if ( !$case ) return [ 'errors' => ___( 'Case not found.' ) ];

    if ( $case->suite_id != $suite_id || $case->project_id != $id ) return [ 'errors' => ___( 'Case not found.' ) ];

    $case->delete();
    $scenario->update( [ 'children' => DB::raw( 'children - 1' ) ] );
    $suites->update( [ 'grand_children' => DB::raw( 'grand_children - 1' ) ] );

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

    $steps = Steps::where( 'case_id', $case_id )->get();

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

    if ( $steps ) {

      Steps::where( 'case_id', $case_id )->delete();

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
          Steps::create( $newstep );
          $i++;

        }

      }

    }

  }

}
