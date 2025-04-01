<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TurPlan extends Model
{
    protected $fillable = ['user_id', 'pharmacy_id', 'amount', 'month', 'year'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pharmacy(){
        return $this->belongsTo(Pharmacy::class);
    }
}
