<?php

namespace App\Jobs;

use App\Models\CaixaCsv;
use Illuminate\Bus\Queueable;
use App\Models\CaixaEconimicaCSV;
use App\Models\EstadosBrasileiro;
use Illuminate\Support\Facades\DB;
use App\Models\FilesCaixaEconomica;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ReadCSVCaixaEconomicaJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $file = null)
    {
        if (!$file) {
            $this->file = FilesCaixaEconomica::whereNull('failed')
                ->orderBy('created_at')->first();
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $file = $this->file;

        if ($file->failed === 0) {
            Log::critical("Arquivo {$file->uuid} já processado em {$file->processed_at}");
            die;
        }

        // DB::rollBack();
        // DB::beginTransaction();
        $file->update([
            'failed' => 1
        ]);
        $data = Storage::get("./Caixa/CSVs/{$file->uuid}.csv");
        if (!$data) {
            Log::critical("Arquivo não encontrado {$file->uuid}");
            die;
        }

        $data = explode(PHP_EOL, $data);
        foreach ($data as $index => $row) {
            // index deve comecar no 4 por causa do cabeçalho do arquivo, ou se a linha for vazia
            if ($index < 4 || !trim($row)) {
                continue;
            }

            $columns = explode(';', $row);

            $uf = strtolower(trim($columns[1]));
            $estado = EstadosBrasileiro::where('uf', $uf)->first();
            if (!$estado) {
                Log::critical("Estado não encontrado: {$uf} arquivo {$file->uuid}:{$index}");
                continue;
            }

            $cidade = $estado
                ->cidades()->firstOrCreate([
                    'nome' => strtoupper($columns[2]),
                ]);

            $num_imovel = $columns[0];

            $oldReg = CaixaCsv::where('num_imovel', $num_imovel)->latest();

            $newReg = $file->csvs()->create([
                'num_imovel' => trim($num_imovel),
                'bairro' => trim(iconv("ISO-8859-1", "UTF-8", $columns[3])),
                'endereco' => trim(iconv("ISO-8859-1", "UTF-8", $columns[4])),
                'cidades_brasileira_id' => $cidade->id,
            ]);
            try {
                $newReg->update([
                    'valor_venda' => trim(str_replace('.', '', str_replace(',', '.', $columns[5]))),
                    'valor_avaliacao' => trim(str_replace('.', '', str_replace(',', '.', $columns[6]))),
                    'desconto' => trim(str_replace('.', '', str_replace(',', '.', $columns[7]))),
                    'modalidade_venda' => trim(iconv("ISO-8859-1", "UTF-8", $columns[9])),
                    'md5_row' => trim(md5($row)),
                ]);
            } catch (\Throwable $th) {
                Log::critical("Falha ao processar o arquivo {$file->uuid}:{$index} ({$newReg->id})");
            }
            $url = $columns[10];
        }
        $file->update([
            'failed' => 0,
            'processed_at' => now()
        ]);
        // DB::commit();
    }
}
