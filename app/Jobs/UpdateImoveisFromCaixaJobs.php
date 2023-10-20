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
    public function __construct(protected CaixaImovel $caixImovel)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $caixImovel = $this->caixImovel;

        $cidade = $caixImovel->cidade;
        $estado = $caixImovel->estado;

        $items = $caixImovel->items()->get();

        $endereco = $items->filter(fn ($item) => $item->slug == 'endereco')->toArray();
        $endereco = end($endereco);


        if (!isset($endereco['pivot']['value']) || !$endereco['pivot']['value']) {
            return;
        }

        preg_match("/CEP:\s*(\d{5}-?\d{3})/", $endereco['pivot']['value'], $matches);
        $cep = str_replace("-", "", $matches[1]);

        $situacao = $items->filter(fn ($item) => $item->slug == 'situacao')->toArray();
        $situacao = end($situacao)['pivot']['value'];

        $tipo_de_imovel = $items->filter(fn ($item) => $item->slug == 'tipo_de_imovel')->toArray();
        $tipo_de_imovel = end($tipo_de_imovel)['pivot']['value'];

        $forma_de_pagamento = $items->filter(fn ($item) => $item->slug == 'forma_de_pagamento');

        $subitems = $forma_de_pagamento->map(function ($subitem) {
            $subitem = $subitem->toArray();
            return $subitem['pivot']['value'];
        });

        $imovel = Imovel::withTrashed()->UpdateOrCreate([
            'num_imovel' => $caixImovel->num_imovel
        ], [
            'cidades_brasileira_id' => $cidade->id,
            'cidade' => $cidade->nome,
            'estados_brasileiro_id' => $estado->id,
            'estado' => $estado->name,
            'cep' => $cep,
            'bairro' => $caixImovel->bairro,
            'property_type_id' => 4,
            'tipo_imovel' => $tipo_de_imovel,
            'situacao' => $situacao === "Ocupado" ? false : true,
            'valor_venda' =>  $caixImovel->valor_venda,
            'valor_avaliacao' =>  $caixImovel->valor_avaliacao,
            'desconto' =>  $caixImovel->desconto,
            'financimento' =>  true,
            // 'consorcio' =>  '$imovel->consorcio',
            // 'parcelamento' =>  '$imovel->parcelamento',
            // 'fgts' =>  '$imovel->fgts',
        ]);

        $imovel->restore();
    }
}
