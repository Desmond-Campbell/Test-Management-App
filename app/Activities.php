<?php

namespace App;

use \App\Model;

class Activities extends Model
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
    protected $table = "activities";

    public static $types = [ 
    													'create_project',
    													'edit_project',
    													'change_project_logo'
                            ];

    public static function getTemplates( $type = null ) {

    	$templates = [];
    	$templates[$type] = [];
    	$all = $type == 'all';

    	if ( $type == 'create_project' || $all ):

	    	// Create project
	    	$template = __( 'Project created by' ) . ' %username%.';
	    	$templates['create_project'] = [ 'default' => $template ];

	    elseif ( $type == 'update_project' || $all ):

	    	$link = '<small><a href="/projects/%project_id%/details" class="view-link">' . ___( "View" ) . '</a></small>';

				// Update project
	    	$template1 = '%username% ' . __( 'updated project details' ) . '. ' . $link;
	    	$template2 = '%username% ' . __( 'updated project details and changed project title from' ) . ' <strong>%old_title%</strong> to <strong>%new_title%</strong>. ' . $link;
	    	$templates['update_project'] = [ 'default' => $template1, 'title_change' => $template2 ];

	    elseif ( $type == 'create_suite' || $all ):

	    	// Create test suite
	    	$link = '<small><a href="/projects/%project_id%/suites?suite_id=%object_id%" class="view-link">' . ___( "View" ) . '</a></small>';
	    	$template = '%username% ' . ___( 'created a new test suite' ) . ' - <strong>%name%</strong>. ' . $link;
	    	$templates['create_suite'] = [ 'default' => $template ];

	    elseif ( $type == 'update_suite' || $all ):

	    	// Update test suite
	    	$link = '<small><a href="/projects/%project_id%/suites?suite_id=%object_id%" class="view-link">' . ___( "View" ) . '</a></small>';
	    	$template = '%username% ' . ___( 'updated test suite' ) . ' <strong>%name%</strong>. ' . $link;
	    	$templates['update_suite'] = [ 'default' => $template ];
	    	$template = '%username% ' . ___( 'renamed test suite' ) . ' <strong>%old_title%</strong> ' . ___("to") . ' %name%.' . $link;
	    	$templates['update_suite']['title_change'] = $template;

	    elseif ( $type == 'delete_suite' || $all ):

	    	// Delete test suite
	    	$template = '%username% ' . ___( 'deleted test suite' ) . ' <strong>%name%</strong>.';
	    	$templates['delete_suite'] = [ 'default' => $template ];

	    elseif ( $type == 'create_scenario' || $all ):

	    	// Create test scenario
	    	$link = '<small><a href="/projects/%project_id%/suites?suite_id=%suite_id%&scenario_id=%object_id%" class="view-link">' . ___( "View" ) . '</a></small>';
	    	$template = '%username% ' . ___( 'created a new test scenario' ) . ' <strong>%name%</strong>. ' . $link;
	    	$templates['create_scenario'] = [ 'default' => $template ];

	    elseif ( $type == 'update_scenario' || $all ):

	    	// Update test scenario
	    	$link = '<small><a href="/projects/%project_id%/suites?suite_id=%suite_id%&scenario_id=%object_id%" class="view-link">' . ___( "View" ) . '</a></small>';
	    	$template = '%username% ' . ___( 'updated test scenario' ) . ' <strong>%name%</strong>. ' . $link;
	    	$templates['update_scenario'] = [ 'default' => $template ];
	    	$template = '%username% ' . ___( 'renamed test scenario' ) . ' <strong>%old_name%</strong> to <strong>%name%</strong>. ' . $link;
	    	$templates['update_scenario'] = [ 'default' => $template ];

	    elseif ( $type == 'upload_scenario_file' || $all ):

	    	// Upload scenario file
	    	$link = '<small><a href="/projects/%project_id%/suites?suite_id=%suite_id%&scenario_id=%scenario_id%" class="view-link">' . ___( "View" ) . '</a></small>';
	    	$template = '%username% ' . ___( 'uploaded a file to scenario' ) . ' <strong>%name%</strong>. ' . $link;
	    	$templates['update_scenario'] = [ 'default' => $template ];

	    elseif ( $type == 'delete_scenario' || $all ):

	    	// Delete test scenario
	    	$template = '%username% ' . ___( 'deleted test scenario' ) . ' <strong>%name%</strong>. ';
	    	$templates['delete_scenario'] = [ 'default' => $template ];

	    elseif ( $type == 'create_test_case' || $all ):

	    	// Create test case
	    	$link = '<small><a href="/projects/%project_id%/suites?suite_id=%suite_id%&scenario_id=%scenario_id%" class="view-link">' . ___( "View" ) . '</a></small>';
	    	$template = '%username% ' . ___( 'created a new test case' ) . ' <strong>%name%</strong>. ' . $link;
	    	$templates['create_test_case'] = [ 'default' => $template ];

	    elseif ( $type == 'update_case' || $all ):

	    	// Update test case
	    	$link = '<small><a href="/projects/%project_id%/suites?suite_id=%suite_id%&scenario_id=%scenario_id%" class="view-link">' . ___( "View" ) . '</a></small>';
	    	$template = '%username% ' . ___( 'made some changes to test case' ) . ' <strong>%name%</strong>. ' . $link;
	    	$templates['update_case'] = [ 'default' => $template ];

	    elseif ( $type == 'delete_case' || $all ):

	    	// Delete test case
	    	$template = '%username% ' . ___( 'deleted test case' ) . ' <strong>%name%</strong>.';
	    	$templates['delete_case'] = [ 'default' => $template ];

	    elseif ( $type == 'update_steps' || $all ):

	    	// Update test steps
	    	$link = '<small><a href="/projects/%project_id%/suites/%suite_id%/edit-case/%object_id%" class="view-link">' . ___( "View" ) . '</a></small>';
	    	$template = '%username% ' . ___( 'updated the steps on test case' ) . ' <strong>%case_name%</strong>. ' . $link;
	    	$templates['update_steps'] = [ 'default' => $template ];

	    elseif ( $type == 'create_test' || $all ):

	    	// Create test
	    	$link = '<small><a href="/projects/%project_id%/tests/%object_id%" class="view-link">' . ___( "View" ) . '</a></small>';
	    	$template = '%username% ' . ___( 'created new test run' ) . ' <strong>%name%</strong>. ' . $link;
	    	$templates['create_test'] = [ 'default' => $template ];

	    elseif ( $type == 'edit_test' || $all ):

	    	// Update test
	    	$link = '<small><a href="/projects/%project_id%/tests/%object_id%" class="view-link">' . ___( "View" ) . '</a></small>';
	    	$template = '%username% ' . ___( 'made some changes to test run' ) . ' <strong>%name%</strong>. ' . $link;
	    	$templates['edit_test'] = [ 'default' => $template ];

	    elseif ( $type == 'update_test_cases' || $all ):

	    	// Update test cases
	    	$link = '<small><a href="/projects/%project_id%/tests/%object_id%" class="view-link">' . ___( "View" ) . '</a></small>';
	    	$template = '%username% ' . ___( 'updated test cases on test run' ) . ' <strong>%name%</strong>. ' . $link;
	    	$templates['update_test_cases'] = [ 'default' => $template ];

	    elseif ( $type == 'update_testers' || $all ):

	    	// Update testers
	    	$link = '<small><a href="/projects/%project_id%/tests/%object_id%" class="view-link">' . ___( "View" ) . '</a></small>';
	    	$template = '%username% ' . ___( 'updated testers on test run' ) . ' <strong>%name%</strong>. ' . $link;
	    	$templates['update_testers'] = [ 'default' => $template ];

	    elseif ( $type == 'delete_test' || $all ):

	    	// Delete test
	    	$template = '%username% ' . ___( 'deleted test run' ) . ' <strong>%name%</strong>.';
	    	$templates['delete_test'] = [ 'default' => $template ];

	    elseif ( $type == 'create_issue' || $all ):

	    	// Create issue
	    	$template = '%username% ' . ___( 'logged a new issue with test case' ) . ' <strong>%case_name%</strong>. ' . $link;
	    	$templates['create_issue'] = [ 'default' => $template ];

	    elseif ( $type == 'create_result' || $all ):

	    	// Create result
	    	$template = '%username% ' . ___( 'logged positive feedback for test case' ) . ' <strong>%case_name%</strong>.';
	    	$templates['create_result'] = [ 'default' => $template ];

	    elseif ( $type == 'add_team_member' || $all ):

	    	// Add team member
	    	$template = '%username% ' . ___( 'added' ) . ' <strong>%name%</strong> ' . ___( "to the project" ) . ' .';
	    	$templates['add_team_member'] = [ 'default' => $template ];

	    elseif ( $type == 'remove_team_member' || $all ):

	    	// Add team member
	    	$template = '%username% ' . ___( 'removed' ) . ' <strong>%name%</strong> ' . ___( "from the project" ) . ' .';
	    	$templates['remove_team_member'] = [ 'default' => $template ];

	    endif;  

    	if ( !$all ) return $templates[$type];
    	else return $templates;

    }

    public static function prepareValues( $values ) {

    	$values_output = [];

    	foreach ( $values['old'] as $key => $value ) {

    		if ( isset( $values['new'][$key] )
    					&& $value != $values['new'][$key] ) 
    			$values_output[$key] = [ 'old' => $value, 'new' => $values['new'][$key] ];

    	}

    	return json_encode( $values_output );

    }

    public static function getContent( $activity ) {

    	$type = $activity->object_type;
    	$content = '';
    	$templates = self::getTemplates( $type );

    	if ( $templates ) {

	    	$template  = @$templates['default'];
	    	$values = (array) @json_decode( $activity->values );

	    	$fields = [];
	    	$fields['username'] = ___( 'Deleted User' );
	    	$fields['project_id'] = $activity->project_id;

	        $user = User::find( $activity->user_id );

	        if ( $user ) $fields['username'] = $user->name;

	    	if ( !is_array( $values ) ) $values = [];

	    	if ( !empty( $values['title'] ) ):

  				$t = $values['title'];

  				if ( !empty( $t->new ) ):

  					$template = $templates['title_change'];

  				endif;

    			$fields['old_title'] = $t->old;
    			$fields['new_title'] = $t->new;

  			endif;

  			$fields['object_id'] = $activity->object_id;

  			$known_fields = [ 'case_name', 'name', 'suite_id', 'case_id' ];

  			foreach ( $known_fields as $k ) {
  				
  				$fields[$k] = arg( $values, $k );

  			}

    		return self::translate( $template, $fields );

    	} else {

    		return '';

    	}

    }

    public static function translate( $template, $fields ) {

    	$target = array_map( function ( $field ) { return "%$field%"; }, array_keys( $fields ) );
    	$replace = array_values( $fields );

    	return str_replace( $target, $replace, $template );

    }
    
}
