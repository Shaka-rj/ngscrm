<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'lastname', 'chat_id', 'region_id', 'role', 'additional'];

    const ROLE_NEWUSER = 1;
    const ROLE_AGENT = 2;
    const ROLE_MANAGER = 3;
    const ROLE_ADMIN = 4;

    public function isNewUser()
    {
        return $this->role == self::ROLE_NEWUSER;
    }

    public function isAgent()
    {
        return $this->role == 2;
    }

    public function isManager()
    {
        return $this->role == 3;
    }

    public function isAdmin()
    {
        return $this->role == 4;
    }

    public function region(){
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function districts(){
        return $this->hasMany(District::class);
    }
}
