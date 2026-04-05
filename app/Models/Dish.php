<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $guarded = [];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class)->withPivot('portions')->withTimestamps();
    }
}
