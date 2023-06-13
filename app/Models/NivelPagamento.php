<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NivelPagamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['description', 'price', 'role_id'];
    protected $casts = [
        'deleted_at' => 'datetime'
    ];
}
