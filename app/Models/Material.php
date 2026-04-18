<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $guarded = [];

    const CATEGORY_CARBOHYDRATE = 'Karbohidrat';
    const CATEGORY_ANIMAL_PROTEIN = 'Protein Hewani';
    const CATEGORY_PLANT_PROTEIN = 'Protein Nabati';
    const CATEGORY_FRUIT = 'Buah';
    const CATEGORY_ADDITIONAL = 'Tambahan';

    public static function getCategories()
    {
        return [
            self::CATEGORY_CARBOHYDRATE,
            self::CATEGORY_ANIMAL_PROTEIN,
            self::CATEGORY_PLANT_PROTEIN,
            self::CATEGORY_FRUIT,
            self::CATEGORY_ADDITIONAL,
        ];
    }

    public function logs()  
    {
        return $this->hasMany(MaterialLog::class);
    }
  
    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }
}
