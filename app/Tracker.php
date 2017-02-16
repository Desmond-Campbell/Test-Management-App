<?php

namespace App;

use \App\Model;
use Illuminate\Support\Facades\Config;

class Tracker extends Model
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
    protected $table = "tracker";

    public static function getSessionId() {

    	$skey = sha1(microtime().rand());

	    if ( !arg( $_COOKIE, config( 'session.la_cookie' ) ) ) {

	      setcookie( config( 'session.la_cookie' ), $skey, time() + ( 60 * 60 * 24 ), "/", "." . env( 'APP_DOMAIN' ) );

	    } else {

	    	$skey = arg( $_COOKIE, config( 'session.la_cookie' ) );

	    }

	    return $skey;

    }

    public static function track( $input ) {

    	$s = $_SERVER;
    	$c = $_COOKIE;

    	$uri = arg( $s, 'REQUEST_SCHEME', '' ) . '://' . arg( $s, 'HTTP_HOST', '' ) . arg( $s, 'REQUEST_URI', '' );
    	$host = arg( $s, 'REMOTE_HOST', '' );
    	$ip = arg( $s, 'REMOTE_ADDR', '' );
    	$agent = arg( $s, 'HTTP_USER_AGENT', '' );
    	$referer = arg( $s, 'HTTP_REFERER', '' );
    	$language = arg( $s, 'HTTP_ACCEPT_LANGUAGE', '' );
    	$time = time();
    	$sid = self::getSessionId();   	
      $globalcookie = arg( $_COOKIE, config( 'session.global_cookie' ) );

    	$mtimes = [];
    	$mtimes[] = mtime() * 10000 + rand( 100, 10000000000 );
    	$mtimes[] = mtime() * 100000 + rand( 100, 1000000000 );
    	$mtimes[] = mtime() * 10000000 + rand( 100, 10000000 );
    	/*$mtimes[] = mtime() * 100000000 + rand( 100, 1000000 );
    	$mtimes[] = mtime() * 1000000000 + rand( 100, 100000 );
    	$mtimes[] = mtime() * 10000000000 + rand( 100, 10000 );
    	$mtimes[] = mtime() * 100000000000 + rand( 100, 1000 );*/
    	$rhash = implode( '.', array_map( function( $h ) { return hash( "crc32b", dechex( crc32( $h ) ) ); }, $mtimes ) );

    	$record = [ 
    							'type'					=> 'init',
    							'ip'						=> $ip,
    							'host' 					=> $host,
    							'uri' 					=> $uri,
    							'language'			=> $language,
    							'agent'					=> $agent,
    							'referer'				=> $referer,
    							'start_time'		=> $time,
    							'sid'						=> $sid,
    							'rhash'					=> $rhash,
    							'globalcookie'	=> $globalcookie,
    							'input'					=> json_encode( $input ),
    							'request'				=> json_encode( $_REQUEST ),
    							'files'					=> json_encode( $_FILES ),
    						];

    	$filepath = base_path() . '/' . env( 'TRACKER_DIRECTORY' ) . '/.' . date( "YmdH") . '.' . $sid;

    	$trackdata = json_encode( $record ) . "\n";

    	file_put_contents( $filepath, $trackdata, FILE_APPEND );

    	Config::set( 'trackerhashid', $rhash );

    }

    public static function updateTime( $timevalue, $pagehash, $properties ) {

    	$sid = self::getSessionId();   	

    	if ( $timevalue && $pagehash ) {

	    	$filepath = base_path() . '/' . env( 'TRACKER_DIRECTORY' ) . '/.' . date( "YmdH") . '.' . $sid;

	    	$update = "\n" . json_encode( [ 'type' => 'update', 'rhash' => $pagehash, 'timevalue' => $timevalue, 'timestamp' => time(), 'properties' => json_encode( $properties ) ] ) . "\n";

  	  	file_put_contents( $filepath, $update, FILE_APPEND );

    	}

    }
    
}
