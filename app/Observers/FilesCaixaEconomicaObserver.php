<?php

namespace App\Observers;

use App\Models\FilesCaixaEconomica;

class FilesCaixaEconomicaObserver
{
    /**
     * Handle the FilesCaixaEconomica "created" event.
     */
    public function created(FilesCaixaEconomica $filesCaixaEconomica): void
    {
        $path = FilesCaixaEconomica::filePath();
        $fullPath = "{$path}/{$filesCaixaEconomica->uuid}.csv";

        $newName = $filesCaixaEconomica->created_at->format('YmdHis');
        $newPath = "{$path}/{$newName}{$filesCaixaEconomica->uuid}.csv";

        rename($fullPath, $newPath);
    }

    /**
     * Handle the FilesCaixaEconomica "updated" event.
     */
    public function updated(FilesCaixaEconomica $filesCaixaEconomica): void
    {
        //
    }

    /**
     * Handle the FilesCaixaEconomica "deleted" event.
     */
    public function deleted(FilesCaixaEconomica $filesCaixaEconomica): void
    {
        //
    }

    /**
     * Handle the FilesCaixaEconomica "restored" event.
     */
    public function restored(FilesCaixaEconomica $filesCaixaEconomica): void
    {
        //
    }

    /**
     * Handle the FilesCaixaEconomica "force deleted" event.
     */
    public function forceDeleted(FilesCaixaEconomica $filesCaixaEconomica): void
    {
        //
    }
}
