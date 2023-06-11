<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['message', 'keyword'];

    public function loggable()
    {
        return $this->morphTo();
    }

    public function user_assignable()
    {
        return $this->morphTo();
    }
}
