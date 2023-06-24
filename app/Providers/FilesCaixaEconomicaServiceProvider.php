<?php

namespace App\Providers;

use App\Models\FilesCaixaEconomica;
use Illuminate\Support\ServiceProvider;
use App\Observers\FilesCaixaEconomicaObserver;

class FilesCaixaEconomicaServiceProvider extends ServiceProvider
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
        FilesCaixaEconomica::observe(FilesCaixaEconomicaObserver::class);
    }
}
