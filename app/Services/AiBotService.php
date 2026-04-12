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
            $systemPrompt = "Anda adalah asisten AI untuk sistem 'BoTo Delphi' (Sistem Makan Bergizi Gratis / MBG). 
            Jawab dengan ramah, informatif, dan profesional dalam Bahasa Indonesia.
            Gunakan data yang diberikan untuk menjawab pertanyaan user. 
            Nama user yang bertanya adalah: $userName.
            Jika user tidak login (Nama: Publik), jangan berikan detail data stok atau keuangan spesifik.
            Jika data tidak ada atau akses terbatas, arahkan user untuk login atau hubungi Admin SPPG.";

            $fullPrompt = "SYSTEM INSTRUCTION:\n$systemPrompt\n\nCONTEXT:\n$context\n\nPERTANYAAN USER: $question";

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
