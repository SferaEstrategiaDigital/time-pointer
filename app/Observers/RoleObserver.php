<?php

namespace App\Observers;

use App\Models\Role;
use Illuminate\Support\Str;

class RoleObserver
{
    /**
     * Handle the Permission "creating" event.
     */
    public function creating(Role $role): void
    {
        $role->uuid = (string)Str::uuid();
        $role->name = Str::slug($role->title);
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updating(Role $role): void
    {
        $role->name = Str::slug($role->title);
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        //
    }
}
