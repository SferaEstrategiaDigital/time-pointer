<?php

namespace App\Models;

use App\Traits\DynamicConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaixaImovel extends Model
{
    // HasFactory para criar dados fake
    // DynamicConnection para determinar qual banco de dados gerenciar
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

    public function imovel()
    {
        return $this->morphMany(Imovel::class, 'imovel');
    }

    function cidade()
    {
        return $this->belongsTo(CidadesBrasileira::class, 'cidades_brasileira_id');
    }

    public function estado()
    {
        return $this->hasOneThrough(
            EstadosBrasileiro::class,
            CidadesBrasileira::class,
            'id',                    // Chave estrangeira em Cidade
            'id',                    // Chave estrangeira em Estado
            'cidades_brasileira_id', // Chave local em Imovel
            'estados_brasileiro_id'  // Chave local em Cidade
        );
    }

    public function items()
    {
        return $this->belongsToMany(CaixaImovelsItem::class, 'caixa_imovels_caixa_imovels_items', 'caixa_imovel_id', 'caixa_imovels_item_id')
            ->withPivot('value')
            ->withTimestamps();
    }
}
