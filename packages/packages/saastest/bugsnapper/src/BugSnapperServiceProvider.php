<?php

namespace SaasTest\BugSnapper;

use Illuminate\Support\ServiceProvider;

class BugSnapperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
        require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'BugSnapperHandler.php';

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('bugsnapper', function ($app) {
            
            $reporter = new BugSnapperReporter();
            
            return $reporter;

        });
    }
}
