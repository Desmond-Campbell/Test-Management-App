<?php

namespace App\Http\Controllers;

use App\Projects;
use App\Suites;
use App\Scenarios;
use App\Cases;
use App\Issues;
use App\Steps;
use App\Batches;
use App\Police;
use App\TestActivities;
use App\Activities;
use App\Tests;
use App\TeamMembers;
use App\User;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;

class TestController extends Controller
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

    police( [ 'project_id' => $id, 'keystring' => 'projects.tests.view_tests', 'return' => $r->input( 'format' ) == 'json' ] );

    $project = Projects::find( $id );

    $tests = Tests::where( 'project_id', $id )->get();

    return view( 'test.index', compact( 'tests', 'project' ) );

  }

  public function overview( Request $r ) {

    $id = $r->route( 'project_id' );
    $test_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 
              'keystring' => 'projects.tests.edit_test', 
              'return' => $r->input( 'format' ) == 'json' ] );

    ////////////////////////////////////////////

    $project = Projects::find( $id );

    return view( 'test.overview', compact( 'project', 'test_id' ) );

  }

  public function testBatches( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.tests.view_batches', 'project_id' => $id ] );

    $test_id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return response()->json( [ 'errors' => __( "Project not found." ) ] );

    $test = Tests::find( $test_id );

    if ( !$test ) return response()->json( [ 'errors' => __( "Test run not found." ) ] );

    return view( 'test.batches', compact( 'project', 'test' ) );

  }

  public function getBatches( Request $r ) {

    $id = $r->route( 'project_id' );
    $test_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.tests.view_batches', 'return' => 1 ] );

    $test = Tests::find( $test_id );

    if ( $test ) {

      if ( $test->project_id != $id ) 
        return response()->json( [ 'errors' => ___( 'Requested test not found on specified project.' ) ] );
    
    }

    $batches = Batches::where( 'test_id', $test_id )->get();

    return response()->json( [ 'batches' => $batches ] );

  }

  public function startBatch( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.tests.start_batch', 'project_id' => $id, 'return' => 1 ] );

    $test_id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return response()->json( [ 'errors' => __( "Project not found." ) ] );

    $test = Tests::find( $test_id );

    if ( !$test ) return response()->json( [ 'errors' => __( "Test run not found." ) ] );

    $runningBatches = Batches::where( 'test_id', $test_id )->where( 'status', 1 )->count();

    if ( $runningBatches ) return response()->json( [ 'errors' => __( "A running batch already exists. You have to stop that batch first before dispatching this test again, because you are dispatching to a set of testers who are already executing this test run. Remember you can always duplicate a test run for another set of testers." ) ] );

    $success = Batches::start( $test_id );

    return response()->json( [ 'success' => $success ] );

  }

  public function stopBatch( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.tests.stop_batch', 'project_id' => $id, 'return' => 1 ] );

    $test_id = $r->route( 'id' );
    $batch_id = $r->route( 'batch_id' );

    $project = Projects::find( $id );

    if ( !$project ) return response()->json( [ 'errors' => __( "Project not found." ) ] );

    $test = Tests::find( $test_id );

    if ( !$test ) return response()->json( [ 'errors' => __( "Test run not found." ) ] );

    $batch = Batches::find( $batch_id );

    if ( !$batch ) return response()->json( [ 'errors' => __( "Test batch was not found." ) ] );

    $success = Batches::stop( $batch_id );

    return response()->json( [ 'success' => $success ] );

  }

  public function launchTest( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.tests.tester', 'project_id' => $id ] );

    $test_id = $r->route( 'id' );
    $batch_id = $r->route( 'batch_id' );

    $project = Projects::find( $id );

    if ( !$project ) return response()->json( [ 'errors' => __( "Project not found." ) ] );

    $test = Tests::find( $test_id );

    if ( !$test ) return response()->json( [ 'errors' => __( "Test run not found." ) ] );

    $batch = Batches::find( $batch_id );

    if ( !$batch ) return response()->json( [ 'errors' => __( "Test batch not found." ) ] );

    $testers = $test->testers;
    
    if ( !$testers ) $testers = '[]';

    $testers = json_decode( $testers );
    $registered_tester = false;

    $user = User::find( get_user_id() );

    if ( $user ) {

      $member = TeamMembers::where( 'project_id', $id )->where( 'user_id', $user->id )->first();

      if ( $member ) {

        $registered_tester = in_array( $member->id, $testers );

      }

      $registered_tester = $registered_tester || $user->is_network_owner;

    }

    if ( !$registered_tester ) {

      $result = [];
      print_r(View::make('index-empty', compact( 'result' ) )->nest('child', 'blocked')->render());
      die;

    }

    return view( 'test.launch', compact( 'project', 'test', 'batch_id' ) );

  }

  public function getBundle( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.tests.edit_test', 'project_id' => $id ] );

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

    police( [ 'keystring' => 'projects.tests.create_test', 'project_id' => $id, 'return' => 1 ] );

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
                  'status'        => 1,
                  'description'   => $description
                ];

      $result_id = Tests::create( $newtest )->id;

      $user_id = get_user_id();

      $filter_hash = sha1( "create_test.$name." . date( 'Y-m-d' ) );
      $activity_values = [ 'name' => $name ];

      $newactivity = [
                        'project_id'    => $id,
                        'object_type'   => 'create_test',
                        'object_id'     => $result_id,
                        'user_id'       => $user_id,
                        'values'        => json_encode( $activity_values ),
                        'filter_hash'   => $filter_hash
                      ];

      Activities::create( $newactivity );

      $result = [ 'success' => true, 'result_id' => $result_id ];

    }

    return response()->json( $result );

  }

  public function getTest( Request $r ) {

    $id = $r->route( 'project_id' );
    $test_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.tests.view_tests', 'return' => 1 ] );

    $test = Tests::find( $test_id );

    if ( $test ) {

      if ( $test->project_id != $id ) 
        return response()->json( [ 'errors' => ___( 'Requested test not found on specified project.' ) ] );
    
    }

    return response()->json( [ 'test' => $test, 'id' => $test_id ] );

  }

  public function updateTest( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.tests.edit_test', 'project_id' => $id, 'return' => 1 ] );

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

      $test = Tests::find( $test_id );
       $user_id = get_user_id();

      $filter_hash = sha1( "update_test.$name." . date( 'Y-m-d' ) );
      $activity_values = [ 'old' => [], 'new' => [] ];
      $activity_values['old']['name'] = $test->name;
      $activity_values['old']['description'] = $test->description;

      $newactivity = [
                        'project_id'    => $id,
                        'object_type'   => 'edit_test',
                        'object_id'     => $test_id,
                        'user_id'       => $user_id,
                        'values'        => Activities::prepareValues( $activity_values ),
                        'filter_hash'   => $filter_hash
                      ];

      $test->update( $changes );

      Activities::create( $newactivity );

      $changes['id'] = $test_id;

      $result = [ 'success' => true, 'result' => $changes ];

    }

    return response()->json( $result );

  }

  public function updateTestCases( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.tests.edit_test', 'project_id' => $id, 'return' => 1 ] );

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

    $test = Tests::find( $test_id );

    $user_id = get_user_id();

    $filter_hash = sha1( "update_test_cases.$test_id." . date( 'Y-m-d' ) );

    $newactivity = [
                      'project_id'    => $id,
                      'object_type'   => 'update_test_cases',
                      'object_id'     => $test_id,
                      'user_id'       => $user_id,
                      'values'        => json_encode( [ 'name' => $test->name ] ),
                      'filter_hash'   => $filter_hash
                    ];

    Activities::create( $newactivity );

    $test->update( $changes );

    $changes['id'] = $test_id;

    $result = [ 'success' => true, 'result' => $changes ];

    return response()->json( $result );

  }

  public function getTesters( Request $r ) {

    $id = $r->route( 'project_id' );
    $test_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.tests.edit_test', 'return' => 1 ] );

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

      if ( Police::check( [ 'keystring' => 'projects.tests.tester',  'quickcheck' => true, 'member_user_id' => $t->user_id , 'project_id' => $id ] ) ) {

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

    police( [ 'keystring' => 'projects.tests.edit_test', 'project_id' => $id, 'return' => 1 ] );

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

    $test = Tests::find( $test_id );

    $user_id = get_user_id();
    $filter_hash = sha1( "update_testers.$test_id." . date( 'Y-m-d' ) );
    
    $newactivity = [
                      'project_id'    => $id,
                      'object_type'   => 'update_testers',
                      'object_id'     => $test_id,
                      'user_id'       => $user_id,
                      'values'        => json_encode( [ 'name' => $test->name ] ),
                      'filter_hash'   => $filter_hash
                    ];

    $test->update( $changes );

    Activities::create( $newactivity );

    $changes['id'] = $test_id;

    $result = [ 'success' => true, 'result' => $changes ];

    return response()->json( $result );

  }

  public function deleteTest( Request $r ) {

    $id = $r->route( 'project_id' );
    $test_id = $r->route( 'id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.tests.delete_test', 'return' => 1 ] );

    $project = Projects::find( $id );

    $test = Tests::find( $test_id );

    if ( !$test ) return [ 'errors' => ___( 'Test not found.' ) ];;

    if ( $test->project_id != $id ) return [ 'errors' => ___( 'Test not found.' ) ];

    $filter_hash = sha1( "delete_test.$test_id." . date( 'Y-m-d' ) );
    $activity_values = [ 'name' => $test->name ];

    $newactivity = [
                      'project_id'    => $id,
                      'object_type'   => 'delete_test',
                      'object_id'     => $test_id,
                      'user_id'       => $user_id,
                      'values'        => json_encode( $activity_values ),
                      'filter_hash'   => $filter_hash
                    ];

    $test->update( $changes );

    Activities::create( $newactivity );

    $test->delete();

    $result = [ 'success' => true ];

    return response()->json( $result );

  }

  public function getTestActivity( Request $r ) {

    $id = $r->route( 'project_id' );
    $test_id = $r->route( 'id' );
    $batch_id = $r->route( 'batch_id' );

    police( [ 'project_id' => $id, 'keystring' => 'projects.tests.tester', 'return' => 1 ] );

    $test = Tests::find( $test_id );

    if ( $test ) {

      if ( $test->project_id != $id ) 
        return response()->json( [ 'errors' => ___( 'Requested test not found on specified project.' ) ] );
    
    }

    $step = (object) [ 'id' => 0 ];

    $activity = TestActivities::where( 'project_id', $id )->where( 'user_id', get_user_id() )->where( 'test_id', $test_id )->where('batch_id', $batch_id)->where( 'status', '1' )->first();

    $batch = Batches::where( 'id', $batch_id )->where( 'status', 1 )->first();

    if ( !$activity ) return response()->json( [ 'case' => (object) [], 'activity' => (object) [], 'scenario' => (object) [], 'step' => (object) [] ] );

    $step = Steps::find( $activity->current_step );

    $case = Cases::find( $activity->case_id );

    $scenario = (object) [];

    if ( $case ) {

      $scenario = Scenarios::find( $case->scenario_id );

    }

    if ( $step ) {

      if ( Steps::where( 'case_id', $step->case_id )->count() == 1
            && $step->name = 'There must be at least 1 step on a test case. This is a default that you can edit or remove.' ) {

        $step->name = '';

      }

    }

    if ( !$batch ) $activity = (object) [];

    return response()->json( [ 'step' => $step, 'activity' => $activity, 'case' => $case, 'scenario' => $scenario ] );

  }

  public function newIssue( Request $r ) {

    $id = $r->route( 'project_id' );
    $activity_id = $r->route( 'activity_id' );
    $step_id = $r->route( 'step_id' );
    $batch_id = $r->route( 'batch_id' );

    police( [ 'keystring' => 'projects.tests.tester', 'project_id' => $id ] );
    police( [ 'keystring' => 'projects.tests.create_issue', 'project_id' => $id ] );

    $test_id = $r->route( 'id' );

    $project = Projects::find( $id );

    if ( !$project ) return response()->json( [ 'errors' => __( "Project not found." ) ] );

    $test = Tests::find( $test_id );
    $step = Steps::find( $step_id );
    $activity = TestActivities::find( $activity_id );

    if ( !$test ) return response()->json( [ 'errors' => __( "Test run not found." ) ] );

    return view( 'test.new-issue', compact( 'project', 'test', 'activity', 'step', 'batch_id' ) );

  }

  public function createIssue( Request $r ) {

    $id = $r->route( 'project_id' );
    $activity_id = $r->route( 'activity_id' );
    $step_id = $r->route( 'step_id' );

    police( [ 'keystring' => 'projects.tests.tester', 'project_id' => $id ] );
    police( [ 'keystring' => 'projects.tests.create_issue', 'project_id' => $id, 'return' => 1 ] );

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

    $step = Steps::find( $step_id );

    if ( !$step )  $err = [ 'errors' => ___( 'Test step was missing from the system. It may have been deleted.' ) ];

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

      $type = $r->input( 'type' ) == 'result' ? 'result' : 'issue';

      $case_id = $step->case_id;
      $case = Cases::find( $case_id );
      $case_name = ___( 'Missing Case' );
      $user_id = get_user_id();

      if ( $case ) $case_name = $case->name;

      $filter_hash = sha1( "create_$type.$case_id." . date( 'Y-m-d' ) );
      $activity_values = [ 'case_name' => $case_name ];

      $newactivity = [
                        'project_id'    => $id,
                        'object_type'   => 'create_' . $type,
                        'object_id'     => $case_id,
                        'user_id'       => $user_id,
                        'values'        => json_encode( $activity_values ),
                        'filter_hash'   => $filter_hash
                      ];

      Activities::create( $newactivity );

      $result = [ 'success' => true, 'result_id' => $result_id ];

    }

    return response()->json( $result );

  }

  public function nextStep( Request $r ) {

    $id = $r->route( 'project_id' );
    $activity_id = $r->route( 'activity_id' );
    $step_id = $r->route( 'step_id' );
    $batch_id = $r->route( 'batch_id' );

    police( [ 'keystring' => 'projects.tests.tester', 'project_id' => $id, 'return' => 1 ] );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    // Find the activity, find the step and add it to skipped steps, then advance

    $activity = TestActivities::find( $activity_id );

    if ( !$activity ) return [ 'errors' => ___( 'Test activity not found.' ) ];

    $skip = $r->route( 'advance_type' ) == 'skip';

    TestActivities::advance( $activity_id, $skip );
    $user_id = get_user_id();

    $result = [ 'success' => true ];

    $newissue = [
                  'title'         => ___( "This test was passed." ),
                  'project_id'    => $id,
                  'activity_id'   => $activity_id,
                  'step_id'       => $step_id,
                  'details'       => ___( "This test was passed." ),
                  'type'          => 'result',
                  'status'        => 1,
                  'user_id'       => get_user_id()
                ];

    Issues::create( $newissue )->id;

    return response()->json( $result );

  }

  public function getResults( Request $r ) {

    $id = $r->route( 'project_id' );
    $test_id = $r->route( 'id' );
    $batch_id = $r->route( 'batch_id' );

    police( [ 'keystring' => 'projects.tests.view_test_results', 'project_id' => $id, 'return' => 1 ] );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

    $activities = TestActivities::where( 'test_id', $test_id )->where( 'batch_id', $batch_id )->get();

    if ( !$activities ) return [ 'errors' => ___( 'Test activity not found.' ) ];

    $batch = Batches::find( $batch_id );

    if ( !$batch ) return [ 'errors' => ___( 'Test batch not found.' ) ];

    $results = [];

    foreach ( $activities as $a ) {

      $issues = Issues::where( 'activity_id', $a->id )->where( 'user_id', get_user_id() )->get();

      if ( count( $issues ) ) {

        foreach ( $issues as $i ) {

          $step = Steps::find( $i->step_id );

          if ( $step ) {

            $i->step_name = $step->name;

          } else {

            $i->step_name = '[' . ___( "This step was deleted." ) . ']';

          }

        }

        $case = Cases::find( $a->case_id );

        if ( $case ) {

          $result = [ 'case' => $case ];

        } else {

          $result = [ 'case' => ___( "Test case was deleted." ) ];

        }

        $result['issues'] = $issues;

        $results[] = $result;

      }

    }

    $result = [ 'results' => $results ];

    return response()->json( $result );

  }

  public function getResultsAggregated( Request $r ) {

    $id = $r->route( 'project_id' );
    $test_id = $r->route( 'id' );
    $batch_id = $r->route( 'batch_id' );
    $group_type = $r->route( 'result_type' );

    police( [ 'keystring' => 'projects.tests.view_test_results', 'project_id' => $id, 'return' => 1 ] );

    $project = Projects::find( $id );

    if ( !$project ) return [ 'errors' => ___( 'Project not found.' ) ];

        if ( $group_type != 'batch' ) {
    
          $activities = TestActivities::where( 'test_id', $test_id )->get();

        } else {

          $activities = TestActivities::where( 'test_id', $test_id )->where( 'batch_id', $batch_id )->get();

        }

    if ( !$activities ) return [ 'errors' => ___( 'Test activity not found.' ) ];

    $batch = Batches::find( $batch_id );

    if ( !$batch && $group_type == 'batch' ) return [ 'errors' => ___( 'Test batch not found.' ) ];

    $results = [];

    $case_cache = [];
    $steps_cache = [];
    $cases = [];

    foreach ( $activities as $a ) {

      if ( $batch_id == $a->batch_id || $group_type != 'batch' ) {

        $case_id = $a->case_id;
        $case = empty( $case_cache[$case_id] ) ? Cases::find( $a->case_id ) : $case_cache[$case_id];
        $steps = empty( $steps_cache[$case_id] ) ? Steps::where( 'case_id', $case_id )->orderBy('item_position', 'asc')->get() : $steps_cache[$case_id];

        if ( empty( $cases[$case_id] ) ) $cases[$case_id] = [ 'case' => $case, 'data' => [] ];

        foreach ( $steps as $s ) {

          $sid = $s->item_position;

          if ( empty( $cases[$case_id]['data'][$sid] ) ) $cases[$case_id]['data'][$sid] = [ 'step' => $s, 'results' => [], 'result_type' => 0 ];
          
          $issues = Issues::where( 'activity_id', $a->id )->where( 'step_id', $s->id )->orderBy( 'created_at', 'desc' )->take(10)->get();

          foreach ( $issues as $i ) {

            $u = User::find( $i->user_id );

            if ( $u ) $i->user_name = $u->name;

            if ( count( $cases[$case_id]['data'][$sid]['results'] ) < 10 ) {

              $cases[$case_id]['data'][$sid]['results'][] = $i;

            }

            if ( $i->id < $cases[$case_id]['data'][$sid] || $cases[$case_id]['data'][$sid] < 1 ) $cases[$case_id]['data'][$sid]['result_type'] = $i->type;

          }

        }

      }

    }

    $result = [ 'results' => array_values( $cases ) ];

    return response()->json( $result );

  }

  public function batchResults( Request $r ) {

    $id = $r->route( 'project_id' );

    police( [ 'keystring' => 'projects.tests.view_test_results', 'project_id' => $id ] );

    $test_id = $r->route( 'id' );
    $batch_id = $r->route( 'batch_id' );

    $project = Projects::find( $id );

    if ( !$project ) return response()->json( [ 'errors' => __( "Project not found." ) ] );

    $test = Tests::find( $test_id );

    if ( !$test ) return response()->json( [ 'errors' => __( "Test run not found." ) ] );

    $batch = Batches::find( $batch_id );

    if ( !$batch ) return response()->json( [ 'errors' => __( "Test batch not found." ) ] );

    return view( 'test.batch-results', compact( 'project', 'test', 'batch_id' ) );

  }

}
