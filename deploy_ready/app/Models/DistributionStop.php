<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionStop extends Model
{
    protected $guarded = [];

    public function distributionRoute()
    {
        return $this->belongsTo(DistributionRoute::class);
    }

    public function beneficiaryGroup()
    {
        return $this->belongsTo(BeneficiaryGroup::class, 'beneficiary_id');
    }
}
