<?php

namespace App\Providers;

use App\Models\Imovel;
use App\Observers\ImovelObserver;
use Illuminate\Support\ServiceProvider;

class ImovelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Imovel::observe(ImovelObserver::class);
    }
}
