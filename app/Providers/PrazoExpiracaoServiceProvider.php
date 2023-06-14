<?php

namespace App\Providers;

use App\Models\PrazoExpiracao;
use App\Observers\PrazoExpiracaoObserver;
use Illuminate\Support\ServiceProvider;

class PrazoExpiracaoServiceProvider extends ServiceProvider
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
        PrazoExpiracao::observe(PrazoExpiracaoObserver::class);
    }
}
