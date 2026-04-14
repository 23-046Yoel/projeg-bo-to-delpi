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
            $systemInstruction = "Anda adalah Asisten Virtual Alad Elphi untuk website resmi Program Makan Bergizi Gratis (MBG) di aladelphi.or.id."
                . " Jawab dengan ramah, jelas, dan profesional dalam Bahasa Indonesia."
                . " Nama user yang bertanya: {$userName}."
                . "\n\nTENTANG PROGRAM: MBG dijalankan oleh Yayasan Alad Elphi dan Badan Gizi Nasional (BGN) untuk menyediakan makanan bergizi gratis bagi anak sekolah."
                . "\n\nFORMULIR PENTING:"
                . "\n- Pengaduan: https://aladelphi.or.id/complaints/create"
                . "\n- Daftar Supplier: https://aladelphi.or.id/pendaftaran-pemasok"
                . "\n- Harga Komunitas: https://aladelphi.or.id/harga-komunitas"
                . "\n- Jadwal Menu: https://aladelphi.or.id/jadwal-menu"
                . "\n- Profil Dapur: https://aladelphi.or.id/dapur"
                . "\n\nATURAN:"
                . "\n- Jika ada keluhan, SELALU arahkan ke complaints/create."
                . "\n- Jika ingin jadi supplier, arahkan ke pendaftaran-pemasok."
                . "\n- Untuk data keuangan/stok spesifik, minta user login dulu."
                . "\n- Jika pertanyaan tidak terkait MBG, tolak dengan sopan.";

            // Combine: system instruction + context + question
            $fullText = $systemInstruction
                . "\n\n=== DATA KONTEKS ===\n" . $context
                . "\n\n=== PERTANYAAN USER ===\n" . $question;

            Log::info("Calling Gemini API");

            $response = Http::timeout(60)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($this->baseUrl . '?key=' . $this->apiKey, [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $fullText]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 600,
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? "Gagal mendapatkan respon dari AI.";
            }

            Log::error("Gemini API Error [" . $response->status() . "]: " . $response->body());
            return "Maaf, sistem AI sedang tidak tersedia. Silakan hubungi kami langsung di aladelphi.or.id.";

        } catch (\Exception $e) {
            Log::error("AiBotService Exception: " . $e->getMessage());
            return "Maaf, terjadi kesalahan teknis pada chatbot. Silakan coba lagi nanti.";
        }
    }
}
