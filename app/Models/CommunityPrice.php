<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityPrice extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_verified' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function getPriceFormattedAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
