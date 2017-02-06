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
