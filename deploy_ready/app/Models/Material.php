<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function logs()
    {
        return $this->hasMany(MaterialLog::class);
    }

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }
}
