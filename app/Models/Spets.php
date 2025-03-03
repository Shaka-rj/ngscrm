<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spets extends Model
{
    protected $fillable = ['company', 'customer', 'summ', 'details', 'custom_id', 'year'];

    protected $casts = [
        'details' => 'array', // JSON ustunni array sifatida ishlatish
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($spets) {
            $year = date('Y'); // Joriy yilni olish
            $lastSpets = self::where('year', $year)->latest('id')->first();

            // Agar shu yilda hujjat bo‘lsa, oxirgi ID dan +1, bo‘lmasa 1
            $newId = $lastSpets ? $lastSpets->custom_id + 1 : 1;

            // ID va yilni saqlaymiz
            $spets->custom_id = $newId;
            $spets->year = $year;
        });
    }
}
