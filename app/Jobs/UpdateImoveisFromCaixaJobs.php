<?php

namespace App\Jobs;

use App\Models\CaixaImovel;
use App\Models\CaixaImovelsItem;
use App\Models\Imovel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateImoveisFromCaixaJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected CaixaImovel $imovel)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $imovel = $this->imovel;

        $cidade = $imovel->cidade;
        $estado = $imovel->estado;

        $cepId = CaixaImovelsItem::where('slug', 'endereco')->value('id');
        $endereco = $imovel->items()->where('caixa_imovels_item_id', $cepId)->first();

        if (!$endereco) {
            return;
        }

        preg_match("/CEP:\s*(\d{5}-?\d{3})/", $endereco, $matches);
        $cep = str_replace("-", "", $matches[1]);

        $situacaoId = CaixaImovelsItem::where('slug', 'situacao')->value('id');
        $situacao = $imovel->items()->where('caixa_imovels_item_id', $situacaoId)
            ->first()->toArray();

        // $imovel->items()->where('caixa_imovels_item_id', 18)->get()->map(function ($item) {
        // dd($item->toArray());
        // });

        $imovel = $imovel->imovel()
            ->withTrashed()->UpdateOrCreate([
                'num_imovel' => $imovel->num_imovel
            ], [
                'cidades_brasileira_id' => $cidade->id,
                'cidade' => $cidade->nome,
                'estados_brasileiro_id' => $estado->id,
                'estado' => $estado->name,
                'cep' => $cep,
                'bairro' => $imovel->bairro,
                'property_type_id' => 4,
                'tipo_imovel' => "CASA",
                'situacao' => $situacao['pivot']['value'] === "Ocupado" ? false : true,
                'valor_venda' =>  $imovel->valor_venda,
                'valor_avaliacao' =>  $imovel->valor_avaliacao,
                'desconto' =>  $imovel->desconto,
                // 'financimento' =>  '$imovel->financimento',
                // 'consorcio' =>  '$imovel->consorcio',
                // 'parcelamento' =>  '$imovel->parcelamento',
                // 'fgts' =>  '$imovel->fgts',
            ]);

        $imovel->restore();

        // dd($imovel->toArray());
    }
}
