<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ExCoreService;

class ExCoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
       $this->app->bind('App\Services\IExCoreService', function(){

            return new ExCoreService();

        });
    }
}
