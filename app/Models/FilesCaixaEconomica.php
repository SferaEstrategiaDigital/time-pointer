<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FilesCaixaEconomica extends Model
{
    use HasFactory;
    protected $fillable = ['uuid', 'estados_brasileiro_id', 'md5', 'processed_at', 'failed'];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public static function filePath()
    {
        $path = storage_path("app/Caixa/CSVs");
        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }
        return $path;
    }

    public function estado()
    {
        return $this->belongsTo(EstadosBrasileiro::class, 'estados_brasileiro_id');
    }

    public function imoveisCaixa()
    {
        return $this->hasMany(CaixaImovel::class);
    }

    public function filename(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => (new Carbon($attributes['created_at']))->format('YmdHis') . "{$attributes['uuid']}.csv"
        );
    }
}
