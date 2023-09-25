<?php

namespace App\Models;

use App\Traits\DynamicConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imovel extends Model
{
    // HasFactory para criar dados fake
    // SoftDeletes para gerenciar 
    // DynamicConnection para determinar qual banco de dados gerenciar
    use HasFactory, SoftDeletes;

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
}
