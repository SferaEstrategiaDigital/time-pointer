<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesCaixaEconomica extends Model
{
    use HasFactory;
    protected $fillable = ['uuid', 'uf', 'md5', 'processed_at', 'failed'];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function csvs()
    {
        return $this->hasMany(CaixaCsv::class);
    }
}
