<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $guarded = [];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
