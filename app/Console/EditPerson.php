<?php

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\ArgvInput;

class EditPerson extends Command
{
  
  protected $signature = 'editperson {--database= : Enter network database as is.},
                                  {--sso_id= : Enter global user ID.},
                                  {--sso_permissions= : Enter permissions as JSON string.},
                                  {--sso_name= : Enter global name of user.},
                                              ';
  protected $description = 'Edit a user in network database.';

  public function __construct() {
    
    parent::__construct();
  
  }

  public function handle() {
    
    $argv = new ArgvInput();
    $target = $argv->getParameterOption('--database');
    $sso_permissions = $argv->getParameterOption('--sso_permissions');
    $sso_id = $argv->getParameterOption('--sso_id');
    $sso_name = $argv->getParameterOption('--sso_name');

    if ( !trim( $sso_permissions ) ) $sso_permissions = '[]';

    Kernel::connection( $target );
    Config::set( 'database.default', $target );

    \App\User::where( 'sso_id', $sso_id )->update( [ 'name' => $sso_name, 'permissions_include' => $sso_permissions ] );
    
    $this->info( Artisan::output() );
  
  }

}
