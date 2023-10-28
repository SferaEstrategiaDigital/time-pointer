<?php

namespace App\Http\Resources;

use App\Models\CaixaImovel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResultResource extends JsonResource
{

    private $items = null;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $caixaImovel = CaixaImovel::where('num_imovel', $this->num_imovel)
            ->whereNotNull('scrapped_at')
            ->latest()->first();

        $this->items = $caixaImovel->items()->get();

        return [
            "link" => $this->uuid,
            "situacao" => $this->situacao,
            "title" => $this->cidade,
            "property_type" => $this->tipo_imovel,
            "price" => "R$ " . number_format($this->valor_venda, 2, ',', '.'),
            "desconto" => $this->desconto,
            "endereco" => $caixaImovel->endereco,
            "cep" => $this->getItem("cep"),
            "cidade" => $this->cidade,
            "estado" => $caixaImovel->estado->uf,
            "areaUtil" => "",
            "areaTotal" => "",
        ];
    }

    private function getItem($slug)
    {
        $value = $this->items->filter(fn ($item) => $item->slug == $slug)->first();
        if ($value) {
            return $value->pivot->value;
        }
        return "";
    }
}
