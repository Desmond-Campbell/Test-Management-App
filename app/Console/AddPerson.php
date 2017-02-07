<?php

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\ArgvInput;

class AddPerson extends Command
{
  
  protected $signature = 'addperson {--database= : Enter network database as is.},
                                              {--sso_id= : Enter global user ID.},
                                              {--sso_name= : Enter global name of user.},
                                              ';
  protected $description = 'Create a new user in network database.';

  public function __construct() {
    
    parent::__construct();
  
  }

  public function handle() {
    
    $argv = new ArgvInput();
    $target = $argv->getParameterOption('--database');
    $sso_id = $argv->getParameterOption('--sso_id');
    $sso_name = $argv->getParameterOption('--sso_name');

    Kernel::connection( $target );
    Config::set( 'database.default', $target );

    \App\User::create( [ 'name' => $sso_name, 'sso_id' => $sso_id, 'permissions_include' => '[]' ] );
    
    $this->info( Artisan::output() );
  
  }

}
