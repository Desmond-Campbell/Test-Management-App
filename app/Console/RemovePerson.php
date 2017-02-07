<?php

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\ArgvInput;

class RemovePerson extends Command
{
  
  protected $signature = 'removeperson {--database= : Enter network database as is.},
                                  {--sso_id= : Enter global user ID.},
                                              ';
  protected $description = 'Remove a user from network database.';

  public function __construct() {
    
    parent::__construct();
  
  }

  public function handle() {
    
    $argv = new ArgvInput();
    $target = $argv->getParameterOption('--database');
    $sso_id = $argv->getParameterOption('--sso_id');

    Kernel::connection( $target );
    Config::set( 'database.default', $target );

    \App\User::where( 'sso_id', $sso_id )->delete();
    
    $this->info( Artisan::output() );
  
  }

}
