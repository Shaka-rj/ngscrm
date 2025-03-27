<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = ['user_id', 'region_id', 'district_id', 'userobject_id', 'firstname', 'lastname'];

    // Doctor -> Region
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    // Doctor -> User
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Doctor -> District
    public function distric(){
        return $this->belongsTo(District::class);
    }

    // Doctor -> Object
    public function userobjects(){
        return $this->belongsTo(UserObject::class);
    }

    public function object()
    {
        return $this->belongsTo(UserObject::class, 'object_id'); 
    }

    public function userObject()
    {
        return $this->belongsTo(UserObject::class, 'userobject_id');
    }
}
