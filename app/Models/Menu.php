<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = [];

    public function dishes()
    {
        return $this->belongsToMany(Dish::class)->withPivot('portions', 'porsi_kecil', 'porsi_besar')->withTimestamps();
    }

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }
}
