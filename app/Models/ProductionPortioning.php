<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionPortioning extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function beneficiaryGroup()
    {
        return $this->belongsTo(BeneficiaryGroup::class);
    }
}
