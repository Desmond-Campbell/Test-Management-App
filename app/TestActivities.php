<?php

namespace App;

use \App\Model;

class TestActivities extends Model
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
  protected $table = "test_activities";

  public static function advance( $id, $skip = false ) {

    $activity = self::find( $id );

    if ( !$activity ) return false;

    // Find current step, find steps and move to next, or close out activity and move to next

    $current_step = $activity->current_step;

    $step = Steps::find( $current_step );

    if ( $step ) {

    	$next_step = Steps::where( 'item_position' , '>', $step->item_position )->where( 'case_id', $activity->case_id )->orderBy( 'item_position', 'asc' )->first();

    	if ( !$skip ) {

	    	$completed = $activity->completed_steps;

		    if ( !$completed ) $completed = '[]';

		    $completed = json_decode( $completed );
		    $completed[] = $step->id;
	    	$activity->completed_steps = json_encode( $completed );

	    }

		  if ( $next_step ) {

		    $activity->current_step = $next_step->id;

    	} else {

    		$activity->current_step = 0;
    		$activity->status = 2;

    		$next_activity = TestActivities::where( 'id' , '>', $activity->id )->where( 'test_id', $activity->test_id )->where( 'user_id', get_user_id() )->first();

    		if ( $next_activity ) {

    			$new_step = Steps::where( 'case_id', $next_activity->case_id )->first();
    			$new_step_id = 0;

    			if ( $new_step ) $new_step_id = $new_step->id;

    			$next_activity->current_step = $new_step_id;
    			$next_activity->status = 1;
    			$next_activity->save();

    		}

    	}

    }

    if ( $skip ) {

	    $skipped = $activity->skipped_steps;

	    if ( !$skipped ) $skipped = '[]';

	    $skipped = json_decode( $skipped );

	    $skipped[] = $step->id;

	    $activity->skipped_steps = json_encode( $skipped );

	  }

    $activity->save();

    return true;

  }
  
}
