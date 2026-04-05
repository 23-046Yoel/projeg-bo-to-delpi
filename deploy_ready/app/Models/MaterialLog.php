<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialLog extends Model
{
    protected $guarded = [];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }
}
