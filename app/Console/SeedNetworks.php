<?php

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\ArgvInput;

class SeedNetworks extends Command
{
  
  protected $signature = 'seednetworks {--class= : Enter PHP class name.}';
  protected $description = 'Run seedrs on all network databases.';

  public function __construct() {
    
    parent::__construct();
  
  }

  public function handle() {
    
    $argv = new ArgvInput();

    $networks = DB::table( 'networks' )->get();

    foreach ( $networks as $n ) {
    
      $target = env( 'NETWORK_DATABASE_PREFIX' ) . str_pad( $n->id, 10, "0", STR_PAD_LEFT );
      $domain = $n->domain;
      $class = $argv->getParameterOption('--class');
      
      Kernel::connection( $target );
      Config::set( 'database.default', $target );

      try {

      	$seed_args = [
            '--database' => $target,
            '--force'    => true
        ];

        if ( $class ) $seed_args['--class'] = $class;

        Artisan::call('db:seed', $seed_args );
        
      } catch( Exception $e ) {

      }

      $this->info( "[$domain in $target]" . "\n" . Artisan::output() );

    }
  
  }

}
