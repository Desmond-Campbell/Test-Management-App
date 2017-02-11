<?php

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\ArgvInput;

class NetworkConfig extends Command
{
  
  protected $signature = 'networkconfig {--database= : Enter network database as is.},
                                              {--sso_id= : Enter global user ID.},
                                              {--sso_name= : Enter global name of user.},
                                              {--sso_timezone= : Enter network timezone as is.},
                                              {--sso_network= : Enter network name as is.},
                                              {--sso_network_id= : Enter network ID as is.},
                                              ';
  protected $description = 'Create a default network owner.';

  public function __construct() {
    
    parent::__construct();
  
  }

  public function handle() {
    
    $argv = new ArgvInput();
    $target = $argv->getParameterOption('--database');
    $sso_id = $argv->getParameterOption('--sso_id');
    $sso_name = $argv->getParameterOption('--sso_name');
    $sso_timezone = $argv->getParameterOption('--sso_timezone');
    $sso_network = $argv->getParameterOption('--sso_network');
    $sso_network_id = $argv->getParameterOption('--sso_network_id');

    Kernel::connection( $target );
    Config::set( 'database.default', $target );

    $permissions = '["view_projects","update_project","create_project","view_people","network_owner"]';

    $timezone = new \DateTimeZone( $sso_timezone );
    $timezoneOffset = $timezone->getOffset( new \DateTime );
    $timezoneOffset = $timezoneOffset / ( 60 * 60 );

    \App\User::create( [ 'name' => $sso_name, 'sso_id' => $sso_id, 'permissions_include' => $permissions, 'is_network_owner' => 1 ] );
    \App\Options::set( 'timezone', $sso_timezone );
    \App\Options::set( 'timezone_hours', $timezoneOffset );
    \App\Options::set( 'network_name', $sso_network );
    \App\Options::set( 'network_id', $sso_network_id );
    
    $this->info( Artisan::output() );
  
  }

}
