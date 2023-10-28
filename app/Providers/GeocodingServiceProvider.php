<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GeocodingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('geocoder', function ($app) {
            // This is where you'll initialize and return your geocoding class.
            // For now, we'll return a placeholder.
            return new \App\Services\Geocoding\NominatimGeocoder();
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
