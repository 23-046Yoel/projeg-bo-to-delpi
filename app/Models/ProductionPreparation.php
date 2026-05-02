<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionPreparation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
