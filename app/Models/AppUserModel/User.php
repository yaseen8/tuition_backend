<?php

namespace App\Models\AppUserModel;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public $table='users';
    protected $keyType='string';
    public $timestamps = false;

    protected $fillable = [
        'name','username','password','user_type', 'email', 'phone_no'
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
