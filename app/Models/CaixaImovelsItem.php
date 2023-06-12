<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaixaImovelsItem extends Model
{
    use HasFactory;

    protected $fillable = ['item', 'validated_at'];

    protected $casts = [
        'validated_at' => 'datetime'
    ];
}
