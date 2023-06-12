<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\CaixaImovelsItem;

class CaixaImovelsItemObserver
{
    /**
     * Handle the CaixaImovelsItem "creating" event.
     */
    public function creating(CaixaImovelsItem $caixaImovelsItem): void
    {
        $caixaImovelsItem->slug = Str::slug($caixaImovelsItem->item, '_');
    }

    /**
     * Handle the CaixaImovelsItem "updated" event.
     */
    public function updated(CaixaImovelsItem $caixaImovelsItem): void
    {
        //
    }

    /**
     * Handle the CaixaImovelsItem "deleted" event.
     */
    public function deleted(CaixaImovelsItem $caixaImovelsItem): void
    {
        //
    }

    /**
     * Handle the CaixaImovelsItem "restored" event.
     */
    public function restored(CaixaImovelsItem $caixaImovelsItem): void
    {
        //
    }

    /**
     * Handle the CaixaImovelsItem "force deleted" event.
     */
    public function forceDeleted(CaixaImovelsItem $caixaImovelsItem): void
    {
        //
    }
}
