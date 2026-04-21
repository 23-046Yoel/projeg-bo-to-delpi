<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LpjSppg extends Model
{
    protected $fillable = [
        'period_start',
        'period_end',
        'target_peserta',
        'realisasi_peserta',
        'target_pendidik',
        'realisasi_pendidik',
        'target_3b',
        'realisasi_3b',
        'anggaran_bahan',
        'realisasi_bahan',
        'anggaran_ops',
        'realisasi_ops',
        'anggaran_insentif',
        'realisasi_insentif',
        'ketua_yayasan',
        'ppk_nama',
        'head_sppg_nama',
        'report_date',
        'organoleptik_data',
        'buku_bantu_bahan',
        'buku_bantu_ops',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'report_date' => 'date',
        'organoleptik_data' => 'array',
        'buku_bantu_bahan' => 'array',
        'buku_bantu_ops' => 'array',
    ];
}
