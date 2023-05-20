<?php

namespace App\Providers;

use App\Models\Permission;
use App\Observers\PermissionObserver;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
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
        Permission::observe(PermissionObserver::class);
    }
}
