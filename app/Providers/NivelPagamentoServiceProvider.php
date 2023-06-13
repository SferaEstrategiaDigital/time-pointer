<?php

namespace App\Providers;

use App\Models\NivelPagamento;
use App\Observers\NivelPagamentoObserver;
use Illuminate\Support\ServiceProvider;

class NivelPagamentoServiceProvider extends ServiceProvider
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
        NivelPagamento::observe(NivelPagamentoObserver::class);
    }
}
