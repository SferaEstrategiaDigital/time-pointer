<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Imovel extends Model
{
    // HasFactory para criar dados fake
    // SoftDeletes para gerenciar 
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        "num_imovel", "cidades_brasileira_id", 'cidade', "estados_brasileiro_id",
        'estado', 'cep', 'bairro', "property_type_id", 'tipo_imovel',
        'situacao', 'valor_venda', 'valor_avaliacao', 'desconto', 'financimento',
        'consorcio', 'parcelamento', 'fgts', "imovel_type", "imovel_id"
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'valor_venda' => 'double',
        'valor_avaliacao' => 'double',
        'desconto' => 'double',
        'situacao' => 'boolean',
        'financimanto' => 'boolean',
        'consorcio' => 'boolean',
        'parcelamento' => 'boolean',
        'fgts' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';  // Use a coluna 'uuid' para model binding
    }
}
