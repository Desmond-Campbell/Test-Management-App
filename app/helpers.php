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

	$id = 0;

	$cookie = arg( $_COOKIE, config( 'session.global_cookie' ) );

	if ( $cookie ) { 
	
		$crumbs = explode( '.', $cookie );

		if ( count( $crumbs ) == 4 ) {

			$login_redir = false;

			$sso_id = (int) $crumbs[2];

			$user = DB::table( 'users' )->where( 'sso_id', $sso_id )->first();

			if ( $user ) {

				$id = $user->id;

			}

		} 

	}

	return $id;

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

	$string = $string !== null && $string != '' ? json_decode( $string ) : [];
	
	if ( $string ) $object = $string;
	else $object = (object) [];

	return $object;

}

function get_url() {

	return base64_encode( $_SERVER['REQUEST_URI'] );

}

function orgpass( $args ) {

  return \App\Police::check( [ 'keystring' => "network.$args", 'quickcheck' => true ] );

}

function pass( $args, $project_id ) {

	$args = [ 'keystring' => "projects.$args", 'quickcheck' => true, 'project_id' => $project_id ];

  return \App\Police::check( $args );

}

function block( $args, $project_id ) {

	return !pass( $args, $project_id );

}

function orgblock( $args, $project_id ) {

	return !orgpass( $args, $project_id );

}

function police( $args ) {

	return \App\Police::check( $args );

}

function ee( $id ) {

	return " [$id]";

}

function http_die( $args ) {

	$link = arg( $args, 'url', 'http://www.saastest.co/' );
	$url = '<p><a href="' . $link . '" target="_blank">' . ___( 'Click here to continue' ) . '</a></p>';

	if ( arg( $_REQUEST, 'request-type' ) == 'full-template' || arg( $args, 'kill' ) ) {

		$output = '<h3>' . ___( 'Error' ) . '</h3><p>' . arg( $args, 'message', ___( 'Sorry, we were unable to process your request.' ) ) . "</p>$url";
		die( $output );

	} else {

		die( arg( $args, 'identifier' ) );

		header( 'Location: ' . $link );
		die;

	}

}

function string_to_words( $string ) {

	return str_replace( [ ',', '.', '!', '#' ], [ '', '', '', '' ], implode( ' ', array_unique( array_filter( explode( ' ', $string ) ) ) ) );

}