<?php

namespace App\Console;

use App\TrackerLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\ArgvInput;

class ParseAccessLogs extends Command
{
  
  protected $signature = 'parseaccesslogs';
  protected $description = 'Parse access logs and export to database.';

  public function __construct() {
    
    parent::__construct();
  
  }

  public function handle() {
    
    $argv = new ArgvInput();
    
    $dir = base_path() . '/' . env( 'TRACKER_DIRECTORY' );
    $d  = opendir( $dir );

    $db = env( 'DB_DATABASE' );
    Kernel::connection( $db );
    Config::set( 'database.default', $db );

    $i = 1;

    while ( $i < env( 'TRACKER_RATE_LIMIT', 10 ) && false !== ( $filename = readdir( $d ) ) ) {

      if ( $filename != '.' && $filename != '..' ) {
    
        $content = str_replace( [ '}{', '} {' ], [ "}\n{", "}\n{" ], file_get_contents( $dir . '/' . $filename ) );

        $lines = array_filter( explode( "\n", $content ) );

        foreach ( $lines as $line ) {

          $data = (array) @json_decode( $line );

          if ( is_array( $data ) ) {

            $type = arg( $data, 'type' );
            $rhash = arg( $data, 'rhash' );

            $hash = sha1( $filename . $rhash );
            $newrecord = TrackerLog::where( 'hash', $hash )->first();

            if ( $type == 'init' ) {

              if ( !$newrecord ) {

                $newrecord = [];
                $newrecord['hash'] = $hash;
                $newrecord['start_time'] = date( 'Y-m-d H:i:s', arg( $data, 'start_time' ) );
                $newrecord['ip'] = arg( $data, 'ip' );
                $newrecord['host'] = arg( $data, 'host' );
                  if ( !$newrecord['host'] && $newrecord['ip'] ) $newrecord['host'] = gethostbyaddr( $newrecord['ip'] );
                $newrecord['uri'] = arg( $data, 'uri' );
                $newrecord['language'] = arg( $data, 'language' );
                $newrecord['agent'] = arg( $data, 'agent' );
                $newrecord['referer'] = arg( $data, 'referer' );
                  $cookie = preg_split( "/\./", arg( $data, 'globalcookie', '0' ) );
                  if ( count( $cookie ) == 4 ) $newrecord['user_id'] = intval( $cookie[2] );
                  else $newrecord['user_id'] = 0;
                $newrecord['input'] = json_encode( arg( $data, 'input', [] ) );
                $newrecord['request'] = json_encode( arg( $data, 'request', [] ) );
                $newrecord['files'] = json_encode( arg( $data, 'files', [] ) );

                TrackerLog::create( $newrecord );

              }

            } elseif ( $type == 'update' ) {

              if ( $newrecord ) {

                $timevalue = arg( $data, 'timevalue', 0 );

                if ( $newrecord->timevalue < $timevalue ) {

                  $newrecord->timevalue = $timevalue;

                }

                $properties = arg( $data, 'properties', [] );

                if ( $properties ) $properties = (array) $properties;

                if ( is_array( $properties ) ) {

                  $newrecord->document_height = arg( $properties, 'dh' );
                  $newrecord->document_width = arg( $properties, 'dw' );
                  $newrecord->window_height = arg( $properties, 'wh' );
                  $newrecord->window_width = arg( $properties, 'ww' );

                }

                $newrecord->save();

              }

            }

          }

        }

        $i++;
        unlink( $dir . '/' . $filename );

      }
    
    }
  
  }

}
