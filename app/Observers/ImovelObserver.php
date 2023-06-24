<?php

namespace App\Observers;

use App\Models\Imovel;
use Illuminate\Support\Str;

class ImovelObserver
{
    /**
     * Handle the Imovel "creating" event.
     */
    public function creating(Imovel $imovel): void
    {
        $imovel->uuid = (string)Str::uuid();
    }

    /**
     * Handle the Imovel "updated" event.
     */
    public function updated(Imovel $imovel): void
    {
        //
    }

    /**
     * Handle the Imovel "deleted" event.
     */
    public function deleted(Imovel $imovel): void
    {
        //
    }

    /**
     * Handle the Imovel "restored" event.
     */
    public function restored(Imovel $imovel): void
    {
        //
    }

    /**
     * Handle the Imovel "force deleted" event.
     */
    public function forceDeleted(Imovel $imovel): void
    {
        //
    }
}
