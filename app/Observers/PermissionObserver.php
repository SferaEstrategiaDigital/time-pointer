<?php

namespace App\Observers;

use App\Models\Permission;
use Illuminate\Support\Str;

class PermissionObserver
{
    /**
     * Handle the Permission "creating" event.
     */
    public function creating(Permission $permission): void
    {
        $permission->uuid = (string)Str::uuid();
        $permission->slug = Str::slug($permission->name);
    }

    /**
     * Handle the Permission "created" event.
     */
    public function created(Permission $permission): void
    {
        if ($permission->ancestors->count()) {
            $slugPath = array_map(fn ($v) => $v['slug'], $permission->ancestors->toArray());
            $slugPath[] = $permission->slug;
            $slugPath = implode('.', $slugPath);
            $permission->slug = $slugPath;
            $permission->save();
        }
    }

    /**
     * Handle the Permission "updated" event.
     */
    public function updated(Permission $permission): void
    {
        //
    }

    /**
     * Handle the Permission "deleted" event.
     */
    public function deleted(Permission $permission): void
    {
        //
    }

    /**
     * Handle the Permission "restored" event.
     */
    public function restored(Permission $permission): void
    {
        //
    }

    /**
     * Handle the Permission "force deleted" event.
     */
    public function forceDeleted(Permission $permission): void
    {
        //
    }
}
