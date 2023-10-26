<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Jobs\DownloadCSVCaixaJobs;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ManageCaixaImovelFilesJob implements ShouldQueue
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
    public function handle(): void
    {
        $estados = \App\Models\EstadosBrasileiro::inRandomOrder()->get();

        foreach ($estados as $estado) {
            DownloadCSVCaixaJobs::dispatchSync($estado);
            sleep(rand(1, 2));
        }
    }
}
