<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    const ROLE_ADMIN = 'admin';
    const ROLE_FINANCE = 'finance';
    const ROLE_WAREHOUSE = 'warehouse';
    const ROLE_ASLAP = 'aslap';
    const ROLE_DRIVER = 'driver';
    const ROLE_HEAD = 'head';
    const ROLE_VOLUNTEER = 'volunteer';
    const ROLE_QC = 'qc';
    const ROLE_NUTRITIONIST = 'nutritionist';

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
