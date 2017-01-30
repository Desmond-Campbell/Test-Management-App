<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        if ( env( 'MULTI_TENANCY_MODE' ) == 'true' ) {

            $db = $this->getTenantDb();

            if ( !$db ) $db = env( 'DB_DATABASE' );

            App::bind('setDbConnection', function($app) use ($db) {
                Config::set( "database.connections.$db", [
                    'driver'        => env('DB_CONNECTION'),
                    'host'          => env('DB_HOST'),
                    'port'          => env('DB_PORT'),
                    'database'      => "$db",
                    'username'      => env('DB_USERNAME'),
                    'password'      => env('DB_PASSWORD'),
                    'charset'       => 'utf8',
                    'collation'     => 'utf8_unicode_ci',
                    'unix_socket'   => env('DB_SOCKET', ''),
                    'prefix'        => '',
                    'strict'        => false,
                    'engine'        => null,
                ]);
            });

            App::make( 'setDbConnection', $db );
            Config::set( 'database.default', $db );

        }
    
    }

    public function getTenantDb() {

        return 'dev_test';

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}
