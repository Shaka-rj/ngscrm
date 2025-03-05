<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'main_price', 'main_percent', 'price', 'vat_percent', 'price_after_vat',
        'main_price2', 'main_percent2', 'price2', 'vat_percent2', 'price_after_vat2', 'expired_data'
    ];
}
