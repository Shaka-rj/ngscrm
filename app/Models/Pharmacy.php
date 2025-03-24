<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $fillable = ['user_id', 'region_id', 'district_id', 'object_id', 'name'];

    // Pharmacy -> Region
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    // Pharmacy -> User
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Pharmacy -> District
    public function district(){
        return $this->belongsTo(District::class);
    }
}
