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
    $i = 0;

    $new_batch = [];
    $new_batch['test_id'] = $test_id;
    $new_batch['project_id'] = $test->project_id;
    $new_batch['status'] = 1;

    self::where( 'test_id', $test_id )->update( [ 'status' => 0 ] );

    $batch_id = self::create( $new_batch )->id;

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
          $new_activity['user_id'] = get_user_id();

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

  public static function stop( $id ) {

    self::find( $id )->update( [ 'status' => 0 ] );

  }
  
}

