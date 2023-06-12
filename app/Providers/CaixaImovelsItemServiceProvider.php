<?php

namespace App\Providers;

use App\Models\CaixaImovelsItem;
use App\Observers\CaixaImovelsItemObserver;
use Illuminate\Support\ServiceProvider;

class CaixaImovelsItemServiceProvider extends ServiceProvider
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
        CaixaImovelsItem::observe(CaixaImovelsItemObserver::class);
    }
}
