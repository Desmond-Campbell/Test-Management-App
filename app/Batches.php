<?php

namespace App;

use \App\Model;

class Batches extends Model
{    
  /**
   * This contains an array of attributes that you do not want to be mass assignable
   * @var array
   */
  protected $guarded = ['id'];
  /**
   * This is the name of the database table for this Model
   * @var string
   */
  protected $table = "test_batches";

  public static function start( $test_id ) {

    $test = Tests::find( $test_id );

    if ( !$test ) return false;

    // Find all the test cases and set up activities;

    $cases = $test->cases;

    if ( !$cases ) $cases = '[]';

    $cases = json_decode( $cases );

    $new_batch = [];
    $new_batch['test_id'] = $test_id;
    $new_batch['project_id'] = $test->project_id;
    $new_batch['status'] = 1;

    self::where( 'test_id', $test_id )->update( [ 'status' => 0 ] );

    $batch_id = self::create( $new_batch )->id;

    $user_id = get_user_id();

      $filter_hash = sha1( "start_batch.$batch_id." . date( 'Y-m-d' ) );
      $activity_values = [ 'test_name' => $test->name ];

      $newactivity = [
                        'project_id'    => $test->project_id,
                        'object_type'   => 'start_batch',
                        'object_id'     => $batch_id,
                        'user_id'       => $user_id,
                        'values'        => json_encode( $activity_values ),
                        'filter_hash'   => $filter_hash
                      ];

      Activities::create( $newactivity );

    $testers = $test->testers;

    if ( !$testers ) return;

    $testers = json_decode( $testers );

    foreach ( $testers as $t ) {

      $i = 0;

      $member = TeamMembers::find( $t );

      if ( $member ) {

        foreach ( $cases as $c ) {

          $case = Cases::find( $c );

          if ( $case ) {

            if ( $case->project_id == $test->project_id ) {

              $new_activity = [];
              $new_activity['project_id'] = $test->project_id;
              $new_activity['batch_id'] = $batch_id;
              $new_activity['case_id'] = $c;
              $new_activity['test_id'] = $test_id;
              $new_activity['current_step'] = 0;
              $new_activity['skipped_steps'] = '[]';
              $new_activity['completed_steps'] = '[]';
              $new_activity['status'] = $i < 1 ? 1 : 0;
              $new_activity['user_id'] = $member->user_id;

              if ( $i < 1 ) {

                $step = Steps::where( 'case_id', $case->id )->orderBy( 'item_position', 'asc' )->first();

                if ( $step ) {

                  $new_activity['current_step'] = $step->id;

                }

              }

              $i++;

              TestActivities::create( $new_activity );
              
            }

          }

        } 

      }

    }

  }

  public static function stop( $id ) {

    $batch = self::find( $id );

    $user_id = get_user_id();

    if ( !$batch ) return;

    $test = Tests::find( $batch->test_id );

    if ( !$test ) return;

      $filter_hash = sha1( "start_batch.$id." . date( 'Y-m-d' ) );
      $activity_values = [ 'test_name' => $test->name ];

      $newactivity = [
                        'project_id'    => $test->project_id,
                        'object_type'   => 'stop_batch',
                        'object_id'     => $id,
                        'user_id'       => $user_id,
                        'values'        => json_encode( $activity_values ),
                        'filter_hash'   => $filter_hash
                      ];

      Activities::create( $newactivity );

    $batch->update( [ 'status' => 0 ] );

  }
  
}

