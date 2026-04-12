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
    const ROLE_KA_SPPG = 'ka_sppg';
    const ROLE_PENGAWAS_GIZI = 'nutrition_supervisor';
    const ROLE_PENGAWAS_KEUANGAN = 'finance_supervisor';
    const ROLE_ASLAP = 'aslap';
    const ROLE_VOLUNTEER = 'volunteer'; // Represents "Publik" in the screenshot
    const ROLE_WAREHOUSE = 'warehouse';
    const ROLE_QC = 'qc';
    const ROLE_DRIVER = 'driver'; // Existing role

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function getRoleTitleAttribute()
    {
        return [
            self::ROLE_ADMIN => 'MASTER ADMIN',
            self::ROLE_KA_SPPG => 'KA SPPG',
            self::ROLE_PENGAWAS_GIZI => 'PENGAWAS GIZI',
            self::ROLE_PENGAWAS_KEUANGAN => 'PENGAWAS KEUANGAN',
            self::ROLE_ASLAP => 'ASISTEN LAPANGAN',
            self::ROLE_VOLUNTEER => 'PUBLIK / RELAWAN',
            self::ROLE_WAREHOUSE => 'STAF GUDANG',
            self::ROLE_QC => 'QUALITY CONTROL',
            self::ROLE_DRIVER => 'DRIVER OPERASIONAL',
        ][$this->role] ?? 'PENGGUNA';
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
