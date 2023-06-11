<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CidadesBrasileira extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];

    public function caixaEconomicaCsv()
    {
        return $this->hasMany(CaixaImovel::class);
    }
}
