<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiaryGroup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }
}
