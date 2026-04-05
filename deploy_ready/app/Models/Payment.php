<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }
}
