<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getAgeAttribute()
    {
        if (!$this->dob) return '-';
        return \Carbon\Carbon::parse($this->dob)->age . ' Thn';
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function group()
    {
        return $this->belongsTo(BeneficiaryGroup::class, 'beneficiary_group_id');
    }

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }

    public function distributions()
    {
        return $this->hasMany(MbgDistribution::class);
    }
}
