<?php

namespace App\Console;

use App\TrackerLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\ArgvInput;

class PurgeLogIp extends Command
{
  
  protected $signature = 'purgelogip {--ips= Enter ips separated by comma.}';
  protected $description = 'Purge records with specific ips from access logs.';

  public function __construct() {
    
    parent::__construct();
  
  }

  public function handle() {
    
    $argv = new ArgvInput();
    $ips = $argv->getParameterOption('--ips');

    $ips = env( 'INTERNAL_IPS' ) . ',' . $ips;

    if ( $ips ) {

      $ips = explode( ',', $ips );

      foreach ( $ips as $ip ) {

        $ip = trim( $ip );

        if ( !$ip ) {

        } elseif ( !stristr( $ip, '*' ) ) {

          TrackerLog::where( 'ip', $ip )->delete();

        } else {

          TrackerLog::where( 'ip', 'LIKE', str_replace( '*', '%', $ip ) )->delete();

        }

      }

    }
  
  }

}
