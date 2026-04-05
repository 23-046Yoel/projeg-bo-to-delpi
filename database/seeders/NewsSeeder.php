<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $dummies = [
            ['title' => 'Program MBG Bantu 3 Juta Anak Indonesia Dapatkan Gizi Seimbang', 'url' => 'https://bgn.go.id/berita/mbg-3-juta-anak'],
            ['title' => 'BGN Luncurkan Panduan Standar Menu Bergizi Nasional 2026',         'url' => 'https://bgn.go.id/berita/panduan-menu-2026'],
            ['title' => 'Petani Lokal Jadi Pahlawan Ketahanan Pangan Program MBG',          'url' => 'https://bgn.go.id/berita/petani-lokal-mbg'],
            ['title' => 'SPPG Bertambah: 500 Dapur Baru Siap Layani Daerah Terpencil',      'url' => 'https://bgn.go.id/berita/sppg-500-dapur'],
            ['title' => 'Transparansi Dana MBG: Setiap Rupiah Tercatat dan Dapat Diaudit',  'url' => 'https://bgn.go.id/berita/transparansi-dana'],
            ['title' => 'Kerjasama BGN dengan Universitas Gizi untuk Standarisasi Menu',    'url' => 'https://bgn.go.id/berita/kerjasama-universitas'],
            ['title' => 'Distribusi MBG Capai 10 Ribu Titik di Seluruh Indonesia',          'url' => 'https://bgn.go.id/berita/distribusi-10ribu'],
        ];

        foreach ($dummies as $d) {
            News::firstOrCreate(
                ['url' => $d['url']],
                ['title' => $d['title'], 'published_at' => now()->toDateString(), 'snippet' => 'Berita resmi Badan Gizi Nasional (BGN).']
            );
        }

        $this->command->info('✅ News seeded: ' . News::count() . ' berita tersimpan.');
    }
}
