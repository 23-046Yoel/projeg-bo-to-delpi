<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiBotService
{
    protected $geminiApiKey;
    protected $groqApiKey;
    protected $geminiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';
    protected $groqUrl   = 'https://api.groq.com/openai/v1/chat/completions';

    public function __construct()
    {
        $this->geminiApiKey = config('services.gemini.key');
        $this->groqApiKey   = config('services.groq.key');
    }

    public function generateResponse(string $question, string $context, string $userName = 'Publik'): string
    {
        $systemInstruction = "Anda adalah Asisten Virtual BoTo Delphi untuk sistem manajemen Program Makan Bergizi Gratis (MBG) di aladelphi.or.id."
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

        // Coba Gemini dulu, fallback ke Groq jika gagal
        if (!empty($this->geminiApiKey)) {
            $result = $this->callGemini($systemInstruction, $context, $question);
            if ($result !== null) {
                return $result;
            }
            Log::warning("AiBotService: Gemini gagal, mencoba Groq sebagai fallback.");
        }

        if (!empty($this->groqApiKey)) {
            $result = $this->callGroq($systemInstruction, $context, $question);
            if ($result !== null) {
                return $result;
            }
        }

        Log::error("AiBotService: Semua provider AI gagal.");
        return "Maaf, sistem AI sementara tidak dapat diakses. Silakan coba beberapa saat lagi atau hubungi kami di aladelphi.or.id.";
    }

    /**
     * Panggil Google Gemini API
     */
    protected function callGemini(string $systemInstruction, string $context, string $question): ?string
    {
        try {
            $fullText = $systemInstruction
                . "\n\n=== DATA KONTEKS ===\n" . $context
                . "\n\n=== PERTANYAAN USER ===\n" . $question;

            Log::info("AiBotService: Memanggil Gemini API");

            $response = Http::timeout(60)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($this->geminiUrl . '?key=' . $this->geminiApiKey, [
                    'contents' => [
                        [
                            'role'  => 'user',
                            'parts' => [['text' => $fullText]]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature'     => 0.7,
                        'maxOutputTokens' => 600,
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($text) {
                    Log::info("AiBotService: Gemini berhasil menjawab.");
                    return $text;
                }
            }

            Log::error("AiBotService: Gemini error [{$response->status()}]: " . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error("AiBotService: Gemini exception: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Panggil Groq API (fallback)
     */
    protected function callGroq(string $systemInstruction, string $context, string $question): ?string
    {
        try {
            Log::info("AiBotService: Memanggil Groq API sebagai fallback");

            $response = Http::timeout(60)
                ->withHeaders([
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $this->groqApiKey,
                ])
                ->post($this->groqUrl, [
                    'model'    => 'llama-3.3-70b-versatile',
                    'messages' => [
                        [
                            'role'    => 'system',
                            'content' => $systemInstruction,
                        ],
                        [
                            'role'    => 'user',
                            'content' => "=== DATA KONTEKS ===\n{$context}\n\n=== PERTANYAAN ===\n{$question}",
                        ],
                    ],
                    'temperature' => 0.7,
                    'max_tokens'  => 600,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['choices'][0]['message']['content'] ?? null;
                if ($text) {
                    Log::info("AiBotService: Groq fallback berhasil menjawab.");
                    return $text;
                }
            }

            Log::error("AiBotService: Groq error [{$response->status()}]: " . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error("AiBotService: Groq exception: " . $e->getMessage());
            return null;
        }
    }
}
