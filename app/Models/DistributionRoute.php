<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionRoute extends Model
{
    protected $guarded = [];

    public function assistant()
    {
        return $this->belongsTo(User::class, 'assistant_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }

    public function stops()
    {
        return $this->hasMany(DistributionStop::class);
    }}
