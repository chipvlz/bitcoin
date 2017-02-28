<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CoinBaseService;
class BitExchangeServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Services\IBitExchangeService', function(){

            return new CoinBaseService();

        });
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['App\Services\IBitExchangeService'];
    }
}
