<?php

namespace App\Jobs;

use App\Models\CaixaImovel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunScrapeCaixaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): bool
    {
        // whereNull('scrapped_at')->
        $toScrape = CaixaImovel::query();

        if (true) {
            $toScrape->where('files_caixa_economica_id', 17);
        }

        $toScrape->inRandomOrder();

        foreach ($toScrape->get() as $item) {
            ScrapeCaixaEconomicaUrlJobs::dispatch($item);
        }
        return true;
    }
}
