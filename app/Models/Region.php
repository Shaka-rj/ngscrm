<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    // Region -> User
    public function users(){
        return $this->hasMany(User::class, 'region_id');
    }

    // Region -> District
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    // Region -> Object
    public function objects(){
        return $this->hasMany(UserObject::class);
    }

    // Region -> Doctor
    public function doctors(){
        return $this->hasMany(Doctor::class);
    }

    // Region -> Pharmacy
    public function pharmacies(){
        return $this->hasMany(Pharmacy::class);
    }
}
