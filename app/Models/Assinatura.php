<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assinatura extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id', 'started_at', 'ended_at',
        'nivel_pagamento_id', 'prazo_expiracao_id'
    ];

    protected $casts = [
        'started_at' =>'datetime',
        'ended_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
}
