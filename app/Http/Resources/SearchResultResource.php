<?php

namespace App\Http\Resources;

use App\Models\CaixaImovel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchResultResource extends JsonResource
{

    private $items = null;
    /**
     * Create a new instance.
     *
     * @param  mixed  $resource  The resource to be transformed.
     * @param  bool   $addPhotos Determines if photos should be added to the transformation.
     * @return void
     */

    function __construct($resource, public $addPhotos = false)
    {
        parent::__construct($resource);
    }
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
            "fotos" => $this->when(true, $this->getItems('/foto.+/i')),
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

    private function getItems($pattern)
    {
        $values = $this->items->filter(function ($item) use ($pattern) {
            return preg_match($pattern, $item->slug);
        });

        return $values->map(function ($item) {
            return $item->pivot->value;
        })->all();
    }
}
