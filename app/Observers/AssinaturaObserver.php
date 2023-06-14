<?php

namespace App\Observers;

use App\Models\Assinatura;
use Illuminate\Support\Str;

class AssinaturaObserver
{
    /**
     * Handle the Assinatura "creating" event.
     */
    public function creating(Assinatura $assinatura): void
    {
        $assinatura->uuid = (string)Str::uuid();
    }

    /**
     * Handle the Assinatura "updated" event.
     */
    public function updated(Assinatura $assinatura): void
    {
        //
    }

    /**
     * Handle the Assinatura "deleted" event.
     */
    public function deleted(Assinatura $assinatura): void
    {
        //
    }

    /**
     * Handle the Assinatura "restored" event.
     */
    public function restored(Assinatura $assinatura): void
    {
        //
    }

    /**
     * Handle the Assinatura "force deleted" event.
     */
    public function forceDeleted(Assinatura $assinatura): void
    {
        //
    }
}
