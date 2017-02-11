<?php

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\ArgvInput;

class MigrateNetwork extends Command
{
  
  protected $signature = 'migratenetwork {--domain= : Enter network domain as stored in networks table.}
                                      {--database= : Enter database name.}
                                                                          ';
  protected $description = 'Run migrations on a single network database.';

  public function __construct() {
    
    parent::__construct();
  
  }

  public function handle() {
    
    $argv = new ArgvInput();
    $target = $argv->getParameterOption('--database');

    if ( !$target ) {

      $target = \App\Networks::getDatabase( $argv->getParameterOption('--domain') );

    }
    
    Kernel::connection( $target );
    Config::set( 'database.default', $target );

    return Artisan::call('migrate', [
        '--database' => $target,
        '--force'    => true
    ]);
    
    $this->info( Artisan::output() );
  
  }

}
