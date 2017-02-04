<?php

namespace App\Http\Controllers;

use App\Projects;
use App\Suites;
use App\Scenarios;
use App\Cases;
use App\Issues;
use App\Steps;
use App\Police;
use App\TestActivities;
use App\Tests;
use App\TeamMembers;
use App\User;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class TestController extends Controller
{

  public function __construct( Request $r )
  {

    if ( $r->input( 'request-type' ) == 'full-template' ) Config::set( 'pageconfig', 'full-template' );

  }

  public function index( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.view_cases', 'return' => 1 ] );

    $project = Projects::find( $id );

    $tests = Tests::where( 'project_id', $id )->get();

    return view( 'test.index', compact( 'tests', 'project' ) );

  }

  public function overview( Request $r ) {

    $id = $r->route( 'project_id' );
    $test_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 
              'keystring' => 'projects.suites.view_suites', 
              'return' => $r->input( 'format' ) == 'json' ] );

    ////////////////////////////////////////////

    $project = Projects::find( $id );

    return view( 'test.overview', compact( 'project', 'test_id' ) );

  }

  public function launchTest( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.suites.create_suite', 'project_id' => $id ] );

    $test_id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return response()->json( [ 'errors' => __( "Project not found." ) ] );

    $test = Tests::find( $test_id );

    if ( !$test ) return response()->json( [ 'errors' => __( "Test run not found." ) ] );

    return view( 'test.launch', compact( 'project', 'test' ) );

  }

  public function getBundle( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.suites.create_suite', 'project_id' => $id ] );

    $test_id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return response()->json( [ 'errors' => __( "Project not found." ) ] );

    $test = Tests::find( $test_id );

    if ( !$test ) return response()->json( [ 'errors' => __( "Test run not found." ) ] );

    $suites = Suites::where( 'project_id', $id )->get();
    $scenarios = $cases = [];

    $selected_suites = $test->suites;

    if ( !$selected_suites ) $selected_suites = '[]';

    $selected_suites = json_decode( $selected_suites );

    $selected_scenarios = $test->scenarios;

    if ( !$selected_scenarios ) $selected_scenarios = '[]';

    $selected_scenarios = json_decode( $selected_scenarios );

    $selected_cases = $test->cases;

    if ( !$selected_cases ) $selected_cases = '[]';

    $selected_cases = json_decode( $selected_cases );

    foreach ( $suites as $suite ) {

      $suite->selected = in_array( $suite->id, $selected_suites );

      $_scenarios = Scenarios::where( 'suite_id', $suite->id )->where( 'project_id', $id )->get();

      foreach ( $_scenarios as $scenario ) {

        $scenario->selected = in_array( $scenario->id, $selected_scenarios );
        $scenarios[] = $scenario;

        $_cases = Cases::where( 'suite_id', $suite->id )->where( 'project_id', $id )->where( 'scenario_id', $scenario->id )->get();

        foreach ( $_cases as $case ) {

          $case->selected = in_array( $case->id, $selected_cases );
          $cases[] = $case;

        }
      
      }
    
    }

    return response()->json( [ 'suites' => $suites, 'scenarios' => $scenarios, 'cases' => $cases ] );

  }

  public function createTest( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.suites.create_suite', 'project_id' => $id, 'return' => 1 ] );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $name = $r->input( 'name' );
    $description = $r->input( 'description' );
    $err = null;

    if ( !$name ) {

      $err = [ 'errors' => ___( 'Please enter a name for this test.' ) ];

    } else {

      $count = Tests::where( 'project_id', $id )->where( 'name', $name )->count();

      if ( $count > 0 ) {

        $err = [ 'errors' => ___( 'The name you entered is already being used for a test run in this project.' ) ];

      }

    }

    if ( $err ) {

      $result = $err;

    } else {

      $newtest = [
                  'name'          => $name,
                  'project_id'    => $id,
                  'description'   => $description
                ];

      $result_id = Tests::create( $newtest )->id;

      $result = [ 'success' => true, 'result_id' => $result_id ];

    }

    return response()->json( $result );

  }

  public function getTest( Request $r ) {

    $id = $r->route( 'project_id' );
    $test_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.view_suites', 'return' => 1 ] );

    $test = Tests::find( $test_id );

    if ( $test ) {

      if ( $test->project_id != $id ) 
        return response()->json( [ 'errors' => ___( 'Requested test not found on specified project.' ) ] );
    
    }

    return response()->json( [ 'test' => $test, 'id' => $test_id ] );

  }

  public function updateTest( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.suites.update_scenarios', 'project_id' => $id, 'return' => 1 ] );

    $test_id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $test = Tests::find( $test_id );

    if ( !$test ) return [ 'errors' => ___( 'Test not found.' ) ];

    $name = $r->input( 'name' );
    $description = $r->input( 'description' );

    $err = null;

    if ( !$name ) {

      $err = [ 'errors' => ___( 'Please enter a title for this test.' ) ];

    } else {

      $count = Tests::where( 'project_id', $id )->where( 'id', '<>', $test_id )->where( 'name', $name )->count();

      if ( $count > 0 ) {

        $err = [ 'errors' => ___( 'The name you entered is already being used in this project.' ) ];

      }

    }

    if ( $err ) {

      $result = $err;

    } else {

      $changes = [
                  'name'          => $name,
                  'description'   => $description
                ];

      Tests::find( $test_id )->update( $changes );

      $changes['id'] = $test_id;

      $result = [ 'success' => true, 'result' => $changes ];

    }

    return response()->json( $result );

  }

  public function updateTestCases( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.suites.update_scenarios', 'project_id' => $id, 'return' => 1 ] );

    $test_id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $test = Tests::find( $test_id );

    if ( !$test ) return [ 'errors' => ___( 'Test not found.' ) ];

    $suites = [];
    $selectedsuites = $r->input( 'suites' );

    foreach ( $selectedsuites as $s ) {

      if ( $s['selected'] ) $suites[] = $s['id'];

    }

    $scenarios = [];
    $selectedscenarios = $r->input( 'scenarios' );

    foreach ( $selectedscenarios as $s ) {

      if ( $s['selected'] ) $scenarios[] = $s['id'];

    }

    $cases = [];
    $selectedcases = $r->input( 'cases' );

    foreach ( $selectedcases as $c ) {

      if ( $c['selected'] ) $cases[] = $c['id'];

    }

    $changes = [
                  'suites'      => json_encode( $suites ),
                  'scenarios'   => json_encode( $scenarios ),
                  'cases'       => json_encode( $cases )
                ];

    Tests::find( $test_id )->update( $changes );

    $changes['id'] = $test_id;

    $result = [ 'success' => true, 'result' => $changes ];

    return response()->json( $result );

  }

  public function getTesters( Request $r ) {

    $id = $r->route( 'project_id' );
    $test_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.view_suites', 'return' => 1 ] );

    $test = Tests::find( $test_id );

    if ( $test ) {

      if ( $test->project_id != $id ) 
        return response()->json( [ 'errors' => ___( 'Requested test not found on specified project.' ) ] );
    
    }

    $selected_testers = $test->testers;

    if ( !$selected_testers ) $selected_testers = '[]';

    $selected_testers = json_decode( $selected_testers );

    $teammembers = TeamMembers::where( 'project_id', $id )->get();
    $testers = [];

    foreach ( $teammembers as $t ) {

      if ( Police::check( [ 'keystring' => 'projects.projects.update_project',  'quickcheck' => true, 'member_user_id' => $t->user_id , 'project_id' => $id ] ) ) {

        $user = User::find( $t->user_id );

        if ( $user ) {

          $t->name = $user->name;
          $t->selected = in_array( $t->id, $selected_testers );
          $testers[] = $t;

        }

      }

    }

    return response()->json( [ 'testers' => $testers, 'id' => $test_id ] );

  }

  public function updateTesters( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.suites.update_scenarios', 'project_id' => $id, 'return' => 1 ] );

    $test_id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $test = Tests::find( $test_id );

    if ( !$test ) return [ 'errors' => ___( 'Test not found.' ) ];

    $testers = [];
    $selectedtesters = $r->input( 'testers' );

    foreach ( $selectedtesters as $s ) {

      if ( $s['selected'] ) $testers[] = $s['id'];

    }

    $changes = [
                  'testers'  => json_encode( $testers )
                ];

    Tests::find( $test_id )->update( $changes );

    $changes['id'] = $test_id;

    $result = [ 'success' => true, 'result' => $changes ];

    return response()->json( $result );

  }

  public function deleteTest( Request $r ) {

    $id = $r->route( 'project_id' );
    $test_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.delete_scenario', 'return' => 1 ] );

    $project = Projects::find( $id );

    $test = Tests::find( $test_id );

    if ( !$test ) return [ 'errors' => ___( 'Test not found.' ) ];;

    if ( $test->project_id != $id ) return [ 'errors' => ___( 'Test not found.' ) ];;

    $test->delete();

    $result = [ 'success' => true ];

    return response()->json( $result );

  }

  public function getTestActivity( Request $r ) {

    $id = $r->route( 'project_id' );
    $test_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.suites.view_suites', 'return' => 1 ] );

    $test = Tests::find( $test_id );

    if ( $test ) {

      if ( $test->project_id != $id ) 
        return response()->json( [ 'errors' => ___( 'Requested test not found on specified project.' ) ] );
    
    }

    $step = (object) [ 'id' => 0 ];

    $activity = TestActivities::where( 'project_id', $id )->where( 'test_id', $test_id )->where( 'status', '1' )->first();

    if ( !$activity ) return response()->json( [ 'case' => (object) [], 'activity' => (object) [], 'scenario' => (object) [], 'step' => (object) [] ] );

    $step = Steps::find( $activity->current_step );

    $case = Cases::find( $activity->case_id );

    $scenario = (object) [];

    if ( $case ) {

      $scenario = Scenarios::find( $case->scenario_id );

    }

    return response()->json( [ 'step' => $step, 'activity' => $activity, 'case' => $case, 'scenario' => $scenario ] );

  }

  public function newIssue( Request $r ) {

    $id = $r->route( 'project_id' );
    $activity_id = $r->route( 'activity_id' );
    $step_id = $r->route( 'step_id' );

    police( [ 'keystring' => 'projects.suites.create_suite', 'project_id' => $id ] );

    $test_id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return response()->json( [ 'errors' => __( "Project not found." ) ] );

    $test = Tests::find( $test_id );
    $step = Steps::find( $step_id );
    $activity = TestActivities::find( $activity_id );

    if ( !$test ) return response()->json( [ 'errors' => __( "Test run not found." ) ] );

    return view( 'test.new-issue', compact( 'project', 'test', 'activity', 'step' ) );

  }

  public function createIssue( Request $r ) {

    $id = $r->route( 'project_id' );
    $activity_id = $r->route( 'activity_id' );
    $step_id = $r->route( 'step_id' );

    police( [ 'keystring' => 'projects.suites.create_suite', 'project_id' => $id, 'return' => 1 ] );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $title = $r->input( 'title' );
    $details = $r->input( 'details' );
    $err = null;

    if ( !$title && $details ) {

      $title = substr( $details, 0, 255 );

    } 

    if ( $title && !$details ) {

      $details = $title;

    } 

    if ( !$title && !$details ) {

      $err = [ 'errors' => ___( 'Please enter a title or write some details to create this issue/result.' ) ];

    }

    if ( $err ) {

      $result = $err;

    } else {

      $newissue = [
                    'title'         => $title,
                    'project_id'    => $id,
                    'activity_id'   => $activity_id,
                    'step_id'       => $step_id,
                    'details'       => $details,
                    'type'          => $r->input( 'type' ) == 'result' ? 'result' : 'issue',
                    'status'        => 1,
                    'user_id'       => get_user_id()
                  ];

      TestActivities::advance( $activity_id );

      $result_id = Issues::create( $newissue )->id;

      $result = [ 'success' => true, 'result_id' => $result_id ];

    }

    return response()->json( $result );

  }

  public function nextStep( Request $r ) {

    $id = $r->route( 'project_id' );
    $activity_id = $r->route( 'activity_id' );
    $step_id = $r->route( 'step_id' );

    police( [ 'keystring' => 'projects.suites.create_suite', 'project_id' => $id, 'return' => 1 ] );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    // Find the activity, find the step and add it to skipped steps, then advance

    $activity = TestActivities::find( $activity_id );

    if ( !$activity ) return [ 'errors' => ___( 'Test activity not found.' ) ];

    $skip = $r->route( 'advance_type' ) == 'skip';

    TestActivities::advance( $activity_id, $skip );

    $result = [ 'success' => true ];

    return response()->json( $result );

  }

}
