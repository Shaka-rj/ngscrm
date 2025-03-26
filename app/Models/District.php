<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['user_id', 'region_id', 'name'];

    // District -> Region
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    // District -> User
    public function user(){
        return $this->belongsTo(User::class);
    }

    // District -> UserObject
    public function userobjects(){
        return $this->hasMany(UserObject::class, 'district_id', 'id');
    }

    // District -> Pharmacy
    public function pharmacies(){
        return $this->hasMany(Pharmacy::class);
    }
}
