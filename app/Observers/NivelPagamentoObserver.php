<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\NivelPagamento;

class NivelPagamentoObserver
{
    /**
     * Handle the NivelPagamento "creating" event.
     */
    public function creating(NivelPagamento $nivelPagamento): void
    {
        $nivelPagamento->uuid = (string)Str::uuid();
    }

    /**
     * Handle the NivelPagamento "updated" event.
     */
    public function updated(NivelPagamento $nivelPagamento): void
    {
        //
    }

    /**
     * Handle the NivelPagamento "deleted" event.
     */
    public function deleted(NivelPagamento $nivelPagamento): void
    {
        //
    }

    /**
     * Handle the NivelPagamento "restored" event.
     */
    public function restored(NivelPagamento $nivelPagamento): void
    {
        //
    }

    /**
     * Handle the NivelPagamento "force deleted" event.
     */
    public function forceDeleted(NivelPagamento $nivelPagamento): void
    {
        //
    }
}
