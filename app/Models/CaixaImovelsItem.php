<?php

namespace App\Models;

use App\Traits\DynamicConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaixaImovelsItem extends Model
{
    // HasFactory para criar dados fake
    // DynamicConnection para determinar qual banco de dados gerenciar
    use HasFactory, DynamicConnection;

    protected $fillable = ['item', 'validated_at'];

    protected $casts = [
        'validated_at' => 'datetime'
    ];
}
