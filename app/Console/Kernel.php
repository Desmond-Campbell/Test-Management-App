<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        MigrateNetwork::class,
        MigrateNetworks::class,
        UnMigrateNetwork::class,
        UnMigrateNetworks::class,
        SeedNetwork::class,
        SeedNetworks::class,
        IndexNetworks::class,
        IndexNetwork::class,
        NetworkConfig::class,
        AddPerson::class,
        EditPerson::class,
        RemovePerson::class, 
        ParseAccessLogs::class, 
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('indexnetworks')->everyFiveMinutes();
        $schedule->command('parseaccesslogs')->hourlyAt( 18 );
        $schedule->command('parseaccesslogs')->hourlyAt( 48 );
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }

    public static function connection( $database ) {

			App::bind('network', function( $app ) use ( $database ) {

				$connection = [];
				$connection['driver'] = env( 'DB_CONNECTION' );
				$connection['host'] = env( 'DB_HOST' );
				$connection['port'] = env( 'DB_PORT' );
				$connection['database'] = "$database";
				$connection['username'] = env( 'DB_USERNAME' );
				$connection['password'] = env( 'DB_PASSWORD' );

				Config::set( "database.connections.$database", $connection );
			  
			});

			App::make( 'network', $database );

    }
}
