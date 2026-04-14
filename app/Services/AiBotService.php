<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiBotService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
    }

    public function generateResponse(string $question, string $context, string $userName = 'Publik')
    {
        if (!$this->apiKey) {
            return "Maaf, API Key Gemini belum dikonfigurasi. Silakan hubungi admin.";
        }

        try {
            $systemPrompt = <<<PROMPT
Anda adalah **Asisten Virtual Alad Elphi** untuk website resmi Program Makan Bergizi Gratis (MBG) di **aladelphi.or.id**.

IDENTITAS ANDA:
- Nama: Asisten Alad Elphi
- Bahasa: Indonesia yang ramah, jelas, dan profesional
- Fokus: Membantu masyarakat memahami program MBG dan mengarahkan ke formulir yang tepat

TENTANG PROGRAM:
Program Makan Bergizi Gratis (MBG) dijalankan oleh Yayasan Alad Elphi bersama Badan Gizi Nasional (BGN). Program ini menyediakan makanan bergizi gratis untuk anak sekolah melalui dapur-dapur SPPG (Satuan Pelayanan Pemenuhan Gizi) yang tersebar di berbagai wilayah.

FORMULIR & HALAMAN PENTING DI aladelphi.or.id:
1. **Pengaduan / Komplain** → https://aladelphi.or.id/complaints/create
   - Untuk melaporkan masalah kualitas makanan, keterlambatan distribusi, atau keluhan lainnya
   
2. **Pendaftaran Pemasok / Supplier** → https://aladelphi.or.id/pendaftaran-pemasok
   - Untuk supplier/pedagang yang ingin menjadi mitra penyedia bahan baku MBG
   
3. **Harga Komunitas** → https://aladelphi.or.id/harga-komunitas
   - Cek dan laporkan harga bahan pangan di pasar lokal
   
4. **Transparansi Harga** → https://aladelphi.or.id/prices
   - Lihat harga referensi bahan baku yang digunakan program MBG
   
5. **Profil Dapur SPPG** → https://aladelphi.or.id/dapur
   - Informasi lokasi dan profil dapur-dapur MBG
   
6. **Aspirasi & Masukan** → Formulir aspirasi tersedia di halaman utama aladelphi.or.id
   - Untuk menyampaikan saran dan masukan kepada pengelola program

ATURAN PENTING:
- Jika ada pertanyaan soal data keuangan/stok spesifik: minta mereka login dulu
- Jika ada keluhan → SELALU arahkan ke https://aladelphi.or.id/complaints/create
- Jika ada yang ingin jadi supplier → arahkan ke https://aladelphi.or.id/pendaftaran-pemasok
- Jika pertanyaan tidak terkait program MBG → tolak dengan sopan
- Nama user yang sedang bertanya adalah: $userName

DATA KONTEKS SPPG (untuk user yang sudah login):
$context
PROMPT;

            $fullPrompt = "PERTANYAAN USER: $question\n\nSILAKAN JAWAB BERDASARKAN INSTRUKSI DI ATAS:";

            Log::info("Calling Gemini 1.5 Flash API");

            $response = Http::timeout(60)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($this->baseUrl . '?key=' . $this->apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $fullPrompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 800,
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? "Gagal mendapatkan respon dari AI.";
            }

            Log::error("Gemini API Error [" . $response->status() . "]: " . $response->body());
            
            return "Terjadi kesalahan saat menghubungi server AI (Code: " . $response->status() . "). Silakan hubungi tim teknis.";

        } catch (\Exception $e) {
            Log::error("AiBotService Exception: " . $e->getMessage());
            return "Maaf, terjadi kesalahan teknis pada chatbot. Silakan coba lagi nanti.";
        }
    }
}
