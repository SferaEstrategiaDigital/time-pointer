<?php

namespace App\Jobs;

use App\Models\CaixaImovel;
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

        // $estadoBras = $file->estado()->first(); // para buscar os registros de ImovelCaixa que esta ativos

        if ($file->failed === 0) {
            Log::critical("Arquivo {$file->uuid} já processado em {$file->processed_at}");
            die;
        }

        $file->update([
            'failed' => 1
        ]);
        $data = Storage::get("./Caixa/CSVs/{$file->filename}");
        if (!$data) {
            Log::critical("Arquivo não encontrado {$file->uuid}");
            die;
        }

        $changed = collect();

        $data = explode(PHP_EOL, $data);
        foreach ($data as $index => $row) {
            // index deve comecar no 4 por causa do cabeçalho do arquivo, ou se a linha for vazia
            if ($index < 4 || !trim($row)) {
                continue;
            }

            $columns = explode(';', $row);

            $num_imovel = trim($columns[0]);

            $md5Row = md5($row);

            // Busca pelo registro mais recente onde o num do imovel seja o que estou buscando
            $oldReg = CaixaImovel::where('num_imovel', $num_imovel)->latest()->first();

            if ($oldReg && $oldReg->md5_row === $md5Row) {
                continue;
            }

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

            // LEMBRA DE REPARAR ABAIXO
            $valor_venda = str_replace(',', '.', str_replace('.', '', $columns[5]));

            // Em casos onde há ponto-e-vírgula no endereço usar outra forma de extrair as colunas.
            if (trim($valor_venda) !== floatval($valor_venda)) {
                // Separa a linha com erro até a coluna que costuma falhar
                $damagedRow = explode(';', $row, 5);
                // extrai o resto da string para correção
                $newRow = array_pop($damagedRow);
                // Busca com regex onde fica o primeiro valor monetário, será usado como base para a separação
                preg_match("/.+?;([0-9\.]+,[0-9]{2})?;/", $newRow, $matches, PREG_OFFSET_CAPTURE);
                // Extrai da busca acima a posição de corte
                $positionToSplit = $matches[1][1];
                // Extrai o enderço, o menos um é para ignorar o ponto-e-vírgula
                $address = substr($newRow, 0, $positionToSplit - 1);
                // Extrai o resto dos dados e separa por ponto-e-vírgula
                $restRow = explode(';', substr($newRow, $positionToSplit));
                // Colunas refeitas
                $columns = array_merge($damagedRow, [$address], $restRow);

                // Repara o "valor de venda", LEMBRA DE REPARAR ACIMA
                $valor_venda = trim(str_replace(',', '.', str_replace('.', '', $columns[5])));
            }

            $newReg = $file->imoveis()->create([
                'num_imovel' => $num_imovel,
                'bairro' => iconv("ISO-8859-1", "UTF-8", $columns[3]),
                'endereco' => iconv("ISO-8859-1", "UTF-8", $columns[4]),
                'cidades_brasileira_id' => $cidade->id,
                'valor_venda' => $valor_venda,
                'valor_avaliacao' => str_replace(',', '.', str_replace('.', '', $columns[6])),
                'desconto' => floatval($columns[7]),
                'modalidade_venda' => iconv("ISO-8859-1", "UTF-8", $columns[9]),
                'md5_row' => $md5Row,
            ]);

            $changed->add([
                $oldReg,
                $newReg
            ]);

            // Log::info($oldReg->tojson());
            // Log::info($newReg->tojson());

            // $url = $columns[10]; // TODO: analisar no futuro a URL
        }
        $file->update([
            'failed' => 0,
            'processed_at' => now()
        ]);

        // Ao ler o arquivo, vrificar como apagar editar e adicionar imoveis
        // Buscar por imoveis onde o estado e o banco é o mesmo

        // [null, ImovelCaixa] => ImovelCaixa novo
        // [ImovelCaixa, null] => Não vai acontecer, pq a base é o arquivo e não os registros antigos
        // [ImovelCaixa, ImovelCaixa] => ImovelCaixa atualizado
    }
}
