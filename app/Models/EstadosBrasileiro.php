<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadosBrasileiro extends Model
{
    use HasFactory;

    public function filesCaixaEconomica()
    {
        return $this->hasMany(FilesCaixaEconomica::class);
    }

    public function cidades()
    {
        return $this->hasMany(CidadesBrasileira::class);
    }
}
