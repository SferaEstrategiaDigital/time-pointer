<?php

namespace App\Jobs;

use App\Models\CaixaCsv;
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
        $toScrape = CaixaCsv::whereNull('scrapped_at')->inRandomOrder()->get();

        foreach ($toScrape as $item) {
            ScrapeCaixaEconomicaUrlJobs::dispatch($item);
            // sleep(rand(rand(3, 6), rand(8, 11)));
            // sleep(1);
        }
        return true;
    }
}
