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

            App::bind('client', function($app) use ($db) {

                $connection = [];
                $connection['driver'] = env( 'DB_CONNECTION' );
                $connection['host'] = env( 'DB_HOST' );
                $connection['port'] = env( 'DB_PORT' );
                $connection['database'] = "$db";
                $connection['username'] = env( 'DB_USERNAME' );
                $connection['password'] = env( 'DB_PASSWORD' );

                Config::set( "database.connections.$db", $connection );
                
            });

            App::make( 'client', $db );
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
