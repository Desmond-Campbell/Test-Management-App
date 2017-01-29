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

    public static function getTemplates( $type ) {

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
	    	$template2 = '%username% ' . __( 'updated project details and changed project title from' ) . ' "<strong>%old_title%</strong>" to "<strong>%new_title%</strong>". ' . $link;
	    	$templates['update_project'] = [ 'default' => $template1, 'title_change' => $template2 ];

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
    	$content = ___( 'Nothing found.' );
    	$templates = self::getTemplates( $type );
    	$template = $templates['default'];
    	$values = (array) @json_decode( $activity->values );

    	$fields = [];
    	$fields['username'] = 'User';
    	$fields['project_id'] = $activity->project_id;

    	if ( !is_array( $values ) ) $values = [];

    	switch ( $type ):

    		case 'create_project':

    			$content = $template;

    		break;

    		case 'update_project':

    			if ( !empty( $values['title'] ) ):

    				$t = $values['title'];

    				if ( !empty( $t->new ) ):

    					$template = $templates['title_change'];

    				endif;

	    			$fields['old_title'] = $t->old;
	    			$fields['new_title'] = $t->new;

    			endif;

    			$content = self::translate( $template, $fields );

    		break;

    	endswitch;

    	return $content;

    }

    public static function translate( $template, $fields ) {

    	$target = array_map( function ( $field ) { return "%$field%"; }, array_keys( $fields ) );
    	$replace = array_values( $fields );

    	return str_replace( $target, $replace, $template );

    }
    
}
