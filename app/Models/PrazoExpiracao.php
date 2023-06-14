<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrazoExpiracao extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['duration'];

    protected $casts = [
        'duration' => 'datetime',
        'deleted_at' => 'datetime'
    ];
}
