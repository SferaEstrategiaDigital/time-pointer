<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaixaImovel extends Model
{
    use HasFactory;

    protected $fillable = [
        'insc_imobiliaria', 'scrapped_at', 'detalhes',
        'desconto', 'modalidade_venda', 'endereco',
        'bairro', 'property_type_id', 'num_quartos', 'md5_row',
        'num_imovel', 'valor_venda', 'valor_avaliacao',
        'cidades_brasileira_id', 'averbacao_leiloes_negativos',
    ];

    protected $casts = [
        ['valor_venda' => 'double'],
        ['valor_avaliacao' => 'double'],
        ['desconto' => 'double'],
        ['scrapped_at' => 'datetime']
    ];

    public function logs()
    {
        return $this->morphMany(Log::class, 'loggable');
    }

    public function items()
    {
        return $this->belongsToMany(CaixaImovelsItem::class, 'caixa_imovels_caixa_imovels_items');
    }

    public function imovel()
    {
        return $this->morphMany(Imovel::class, 'imovel');
    }
}
