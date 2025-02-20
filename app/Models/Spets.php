<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spets extends Model
{
    protected $fillable = ['company', 'customer', 'summ', 'details'];

    protected $casts = [
        'details' => 'array', // JSON ustunni array sifatida ishlatish
    ];
}
