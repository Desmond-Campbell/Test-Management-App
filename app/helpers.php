<?php

define( 'MAX_TEXT_LENGTH', 1024 );
define( 'MAX_STRING_LENGTH', 255 );

function findOrFail( $args ) {

	$class = $args['class'];
	$id = $args['id'];
	$redirect = !empty( $args['redirect'] ) ? $args['redirect'] : '';

	$record = call_user_func_array( [ "\\App\\$class", 'find' ], [ $id ] );

	if ( $record ) return $record;

	if ( $redirect ) {

		header( 'Location: ' . $redirect );
		die;

	}

	return null;

}

function ___( $text, $lang = null ) {
	
	return $text;

}

function get_user_id() {

	return 1;

}