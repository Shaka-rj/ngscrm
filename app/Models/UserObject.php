<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserObject extends Model
{
    protected $table = 'userobjects'; 
    protected $fillable = ['user_id', 'region_id', 'district_id', 'name'];

    // Object -> Region
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    // Object -> User
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Object -> District
    public function district(){
        return $this->belongsTo(District::class, 'district_id');
    }

    // Object -> Doctor
    public function doctors(){
        return $this->hasMany(Doctor::class, 'userobject_id');
    }
}
