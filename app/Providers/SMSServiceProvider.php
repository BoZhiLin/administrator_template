<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Tools\Factories\Nexmo;

class SMSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('nexmo', function ($app) {
            return new Nexmo;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
