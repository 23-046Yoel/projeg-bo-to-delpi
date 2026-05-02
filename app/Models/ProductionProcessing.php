<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionProcessing extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
