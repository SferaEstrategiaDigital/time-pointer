<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaixaCsv extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_imovel', 'valor_venda', 'valor_avaliacao',
        'desconto', 'modalidade_venda', 'endereco',
        'bairro', 'tipo_imovel', 'quartos', 'md5_row',
        'inscr_imobiliaria', 'scrapped_at',
        'cidades_brasileira_id'
    ];

    protected $casts = [
        ['valor_venda' => 'double'],
        ['valor_avaliacao' => 'double'],
        ['desconto' => 'double'],
        ['scrapped_at' => 'datetime']
    ];
}
