<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SearchResultsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($imovel) {
                return new SearchResultResource($imovel);
            }),
            'meta' => [
                'current_page' => $this->currentPage(),    // Número da página atual.
                'last_page'    => $this->lastPage(),       // Número da última página.
                'per_page'     => $this->perPage(),        // Número de itens por página.
                'from'         => $this->firstItem(),      // Número do primeiro item na página atual.
                'to'           => $this->lastItem(),       // Número do último item na página atual.
                'total'        => $this->total(),          // Total de itens na coleção.
                'path'         => $this->path(),           // URL base para as páginas.
                'next_page_url' => $this->nextPageUrl(),    // URL da próxima página.
                'prev_page_url' => $this->previousPageUrl(), // URL da página anterior.
                'first_page_url' => $this->url(1),          // URL da primeira página.
                'last_page_url' => $this->url($this->lastPage()), // URL da última página.

            ],
        ];
    }
}
