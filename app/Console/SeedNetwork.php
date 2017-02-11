<?php

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\ArgvInput;

class SeedNetwork extends Command
{
  
  protected $signature = 'seednetwork {--domain= : Enter network domain as stored in networks table.},
                                      {--class= : Enter PHP class name.}
                                      {--database= : Enter database name.}
                                      ';
  protected $description = 'Run seeders on a single network database.';

  public function __construct() {
    
    parent::__construct();
  
  }

  public function handle() {
    
    $argv = new ArgvInput();
    $target = $argv->getParameterOption('--database');

    if ( !$target ) {

      $target = \App\Networks::getDatabase( $argv->getParameterOption('--domain') );

    }
    
    $class = $argv->getParameterOption('--class');
    
    Kernel::connection( $target );
    Config::set( 'database.default', $target );

    $seed_args = [
        '--database' => $target,
        '--force'    => true
    ];

    if ( $class ) $seed_args['--class'] = $class;

    return Artisan::call('db:seed', $seed_args );
    
    $this->info( Artisan::output() );
  
  }

}
