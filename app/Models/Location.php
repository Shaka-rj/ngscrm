<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['user_id', 'type', 'type_id', 'latitude', 'longitude', 'created_at', 'updated_at'];

    public $timestamps = true;

    const DISTRICT  = 'district';
    const USEROBJECT = 'object';
    const DOCTOR    = 'doctor';
    const PHARMACY  = 'pharmacy';

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (!in_array($model->type, [
                self::DISTRICT,
                self::USEROBJECT,
                self::DOCTOR,
                self::PHARMACY
            ])) {
                throw new \InvalidArgumentException("Noto‘g‘ri 'type' qiymati!");
            }
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function district(){
        return $this->belongsTo(District::class, 'type_id');
    }

    public function userobject(){
        return $this->belongsTo(UserObject::class, 'type_id');
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class, 'type_id');
    }

    public function pharmacy(){
        return $this->belongsTo(Pharmacy::class, 'type_id');
    }

}
