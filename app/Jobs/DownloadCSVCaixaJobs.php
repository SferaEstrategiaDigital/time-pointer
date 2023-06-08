<?php

namespace App\Jobs;

use App\Models\EstadosBrasileiro;
use App\Models\FilesCaixaEconomica;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DownloadCSVCaixaJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url = "https://venda-imoveis.caixa.gov.br/listaweb/Lista_imoveis_%s.csv";

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client();
        $path = storage_path("app/Caixa/CSVs");

        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }

        $estados = EstadosBrasileiro::inRandomOrder()->get();

        foreach ($estados as $estado) {

            $fileName = (string)Str::uuid();

            $client->request('GET', sprintf($this->url, $estado->uf), [
                'sink' => $path . "/{$fileName}.csv"
            ]);

            $file = $estado->filesCaixaEconomica()->create([
                'uuid' => $fileName,
                'md5' => md5_file($path . "/{$fileName}.csv")
            ]);

            ReadCSVCaixaEconomicaJobs::dispatch($file);

            sleep(rand(3, 8));
        }
    }
}
