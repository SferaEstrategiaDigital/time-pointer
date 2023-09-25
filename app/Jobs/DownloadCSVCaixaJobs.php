<?php

namespace App\Jobs;

use App\Models\EstadosBrasileiro;
use App\Models\FilesCaixaEconomica;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DownloadCSVCaixaJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url = "https://venda-imoveis.caixa.gov.br/listaweb/Lista_imoveis_%s.csv";

    public function __construct(protected EstadosBrasileiro $estado)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): bool
    {
        $estado = $this->estado;
        $client = new Client([
            'verify' => false,
        ]);

        $path = FilesCaixaEconomica::filePath();

        $fileName = (string)Str::uuid();
        $fullPath = $path . "/{$fileName}.csv";

        try {
            $client->request('GET', sprintf($this->url, $estado->uf), [
                'sink' => $fullPath
            ]);
        } catch (\Throwable $th) {
            Log::critical("Falha ao baixar arquivo do estado {$estado->uf};{$th->getMessage()}");
            Log::critical(json_encode($th->getTrace()));
            return false;
        }

        $md5_file = md5_file($fullPath);

        $md5_check = $estado->filesCaixaEconomica()->where('md5', $md5_file)->count();

        if ($md5_check) {
            Log::critical("Já existe arquivo com o mesmo MD5 ({$md5_file})");
            unlink($fullPath);
            return false;
        }


        $file = $estado->filesCaixaEconomica()->create([
            'uuid' => $fileName,
            'md5' => $md5_file
        ]);

        ReadCSVCaixaEconomicaJobs::dispatch($file);

        return true;
    }
}
