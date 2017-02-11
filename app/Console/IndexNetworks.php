<?php

namespace App\Console;

use App\Search;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\ArgvInput;

class IndexNetworks extends Command
{
  
  protected $signature = 'indexnetworks';
  protected $description = 'Run search index on all network databases.';

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

      	Search::index();
        
      } catch( Exception $e ) {

      }

      $this->info( "[$domain in $target] search index run\n" );

    }
  
  }

}
