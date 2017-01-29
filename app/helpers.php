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

function validate_html_color($color) {
  /* Validates hex color, adding #-sign if not found. Checks for a Color Name first to prevent error if a name was entered (optional).
  *   $color: the color hex value stirng to Validates
  *   $named: (optional), set to 1 or TRUE to first test if a Named color was passed instead of a Hex value
  */

 if (preg_match('/^#[a-f0-9]{6}$/i', $color)) {
    // Verified OK
  } else if (preg_match('/^[a-f0-9]{6}$/i', $color)) {
    $color = '#' . $color;
  } else {
  	return random_colour();
  }
  return $color;
}

function random_colour() {

	return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);;

}

function arg( $A, $key, $default = null ) {

	$A = (array) $A;

	if ( !empty( $A[$key] ) ) return $A[$key];

	return $default;

}

function try_json_decode( $string ) {

	$string = @json_decode( $string );
	
	if ( $string ) $object = $string;
	else $object = (object) [];

	return $object;

}

function get_url() {

	return base64_encode( $_SERVER['REQUEST_URI'] );

}
