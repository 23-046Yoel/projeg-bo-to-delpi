<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sppg_id',
        'latitude',
        'longitude',
        'status',
        'address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }
}
