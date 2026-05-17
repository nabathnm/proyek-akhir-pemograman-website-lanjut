<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'no_telepon',
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Relationships
    public function kos()
    {
        return $this->hasMany(Kos::class, 'pemilik_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }
}
