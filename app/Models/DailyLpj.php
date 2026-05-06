<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyLpj extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
        'material_receipts' => 'array',
        'haccp_preparation' => 'array',
        'haccp_processing' => 'array',
        'distribution_data' => 'array',
        'signatures' => 'array',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }
}
