<?php

namespace App\Providers;

use App\Models\Assinatura;
use App\Observers\AssinaturaObserver;
use Illuminate\Support\ServiceProvider;

class AssinaturaServiceProvider extends ServiceProvider
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
        Assinatura::observe(AssinaturaObserver::class);
    }
}
