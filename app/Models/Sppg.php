<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sppg extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function beneficiaryGroups()
    {
        return $this->hasMany(BeneficiaryGroup::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function attendances()
    {
        return $this->hasMany(VolunteerAttendance::class);
    }
}
