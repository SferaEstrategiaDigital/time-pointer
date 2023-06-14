<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\PrazoExpiracao;

class PrazoExpiracaoObserver
{
    /**
     * Handle the PrazoExpiracao "creating" event.
     */
    public function creating(PrazoExpiracao $prazoExpiracao): void
    {
        $prazoExpiracao->uuid = (string)Str::uuid();
    }

    /**
     * Handle the PrazoExpiracao "updated" event.
     */
    public function updated(PrazoExpiracao $prazoExpiracao): void
    {
        //
    }

    /**
     * Handle the PrazoExpiracao "deleted" event.
     */
    public function deleted(PrazoExpiracao $prazoExpiracao): void
    {
        //
    }

    /**
     * Handle the PrazoExpiracao "restored" event.
     */
    public function restored(PrazoExpiracao $prazoExpiracao): void
    {
        //
    }

    /**
     * Handle the PrazoExpiracao "force deleted" event.
     */
    public function forceDeleted(PrazoExpiracao $prazoExpiracao): void
    {
        //
    }
}
