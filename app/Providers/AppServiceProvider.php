<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
          'App\Http\Contracts\BookingInterface',
          'App\Http\Services\BookingService'
        );
        $this->app->bind(
          'App\Http\Contracts\VehicleInterface',
          'App\Http\Services\VehicleService'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
