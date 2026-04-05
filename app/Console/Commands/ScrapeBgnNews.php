<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ScrapeBgnNews extends Command
{
    protected $signature   = 'bgn:scrape';
    protected $description = 'Scrape berita terbaru dari bgn.go.id dan simpan ke database';

    public function handle(): void
    {
        $this->info('🔍 Mulai scraping bgn.go.id...');

        $sources = [
            'https://bgn.go.id/berita/',
            'https://bgn.go.id/siaran-pers/',
        ];

        $saved = 0;

        foreach ($sources as $url) {
            try {
                $response = Http::timeout(15)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; MBG-Bot/1.0)'])
                    ->get($url);

                if (! $response->ok()) {
                    $this->warn("Gagal mengakses: {$url}");
                    continue;
                }

                $html = $response->body();

                // Cari link artikel dengan regex
                preg_match_all(
                    '/<a[^>]+href=["\']([^"\']*bgn\.go\.id[^"\']*(?:berita|siaran)[^"\']*)["\'][^>]*>(.*?)<\/a>/si',
                    $html,
                    $matches
                );

                $urls   = $matches[1] ?? [];
                $titles = $matches[2] ?? [];

                foreach ($urls as $i => $articleUrl) {
                    $title = strip_tags($titles[$i] ?? '');
                    $title = trim(preg_replace('/\s+/', ' ', $title));

                    if (strlen($title) < 10) continue;
                    if (Str::startsWith($articleUrl, '/')) {
                        $articleUrl = 'https://bgn.go.id' . $articleUrl;
                    }

                    if (News::where('url', $articleUrl)->exists()) continue;

                    News::create([
                        'title'        => Str::limit($title, 200),
                        'url'          => $articleUrl,
                        'published_at' => now()->toDateString(),
                        'snippet'      => 'Berita resmi dari Badan Gizi Nasional (BGN).',
                    ]);

                    $saved++;
                    $this->line("  ✅ Tersimpan: {$title}");
                }

            } catch (\Exception $e) {
                $this->error("Error: " . $e->getMessage());
            }
        }

        // Jika tidak ada berita di DB sama sekali, isi dengan data dummy
        if (News::count() === 0) {
            $this->warn('Tidak ada berita berhasil di-scrape. Menambahkan berita contoh...');
            $dummies = [
                ['title' => 'Program MBG Bantu 3 Juta Anak Indonesia Dapatkan Gizi Seimbang', 'url' => 'https://bgn.go.id/berita/mbg-3-juta-anak'],
                ['title' => 'BGN Luncurkan Panduan Standar Menu Bergizi Nasional 2026',         'url' => 'https://bgn.go.id/berita/panduan-menu-2026'],
                ['title' => 'Petani Lokal Jadi Pahlawan Ketahanan Pangan Program MBG',          'url' => 'https://bgn.go.id/berita/petani-lokal-mbg'],
                ['title' => 'SPPG Bertambah: 500 Dapur Baru Siap Layani Daerah Terpencil',      'url' => 'https://bgn.go.id/berita/sppg-500-dapur'],
                ['title' => 'Transparansi Dana MBG: Setiap Rupiah Tercatat dan Dapat Diaudit',  'url' => 'https://bgn.go.id/berita/transparansi-dana'],
            ];
            foreach ($dummies as $d) {
                News::firstOrCreate(['url' => $d['url']], [
                    'title'        => $d['title'],
                    'published_at' => now()->toDateString(),
                    'snippet'      => 'Berita resmi Badan Gizi Nasional.',
                ]);
            }
            $this->info('Berita contoh berhasil ditambahkan.');
        }

        $this->info("✅ Selesai! Berita baru tersimpan: {$saved}");
    }
}
