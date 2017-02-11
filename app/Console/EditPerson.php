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
                                  {--sso_network_owner= : True or false if person owns network.},
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
    $sso_network_owner = $argv->getParameterOption('--sso_network_owner');

    if ( !trim( $sso_permissions ) ) $sso_permissions = '[]';

    Kernel::connection( $target );
    Config::set( 'database.default', $target );

    $changes = [];

    if ( $sso_name ) $changes['name'] = $sso_name;
    if ( $sso_network_owner ) $changes['is_network_owner'] = $sso_network_owner;
    if ( $sso_permissions ) $changes['permissions_include'] = $sso_permissions;

    if ( count( $changes ) ) \App\User::where( 'sso_id', $sso_id )->update( $changes );
    
    $this->info( Artisan::output() );
  
  }

}
