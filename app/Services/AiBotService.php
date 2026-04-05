<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiBotService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('services.groq.key');
    }

    public function generateResponse(string $question, string $context)
    {
        if (!$this->apiKey) {
            return "Maaf, API Key Groq belum dikonfigurasi. Silakan hubungi admin.";
        }

        // Simple rate limiting
        $cacheKey = 'openai_last_request';
        $lastRequest = Cache::get($cacheKey);
        
        if ($lastRequest && (time() - $lastRequest) < 3) {
            sleep(3);
        }

        try {
            $systemPrompt = "Anda adalah asisten AI untuk sistem 'BoTo Delphi' (Sistem Manajemen Inventori & Keuangan). 
            Jawab dengan ramah dan profesional dalam Bahasa Indonesia.
            Gunakan data yang diberikan untuk menjawab pertanyaan user.
            Jika data tidak ada, jawab bahwa Anda tidak menemukannya di sistem.";

            $userPrompt = "DATA DATABASE:\n$context\n\nPERTANYAAN USER: $question";

            Log::info("Calling Groq API");

            // Record this request time
            Cache::put($cacheKey, time(), 60);

            // Retry logic with exponential backoff
            $maxRetries = 3;
            $retryDelay = 3;

            for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
                $response = Http::timeout(60)
                    ->connectTimeout(30)
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $this->apiKey,
                        'Content-Type' => 'application/json',
                    ])
                    ->withoutVerifying()
                    ->post($this->baseUrl, [
                        'model' => 'llama-3.1-8b-instant',
                        'messages' => [
                            ['role' => 'system', 'content' => $systemPrompt],
                            ['role' => 'user', 'content' => $userPrompt]
                        ],
                        'max_tokens' => 500,
                        'temperature' => 0.7,
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['choices'][0]['message']['content'] ?? "Gagal mendapatkan respon dari AI.";
                }

                // Other errors, log and return
                Log::error("AI API Error [" . $response->status() . "]: " . $response->body());
                
                if ($response->status() === 429) {
                    return "Maaf, server AI sedang sibuk. silahkan  cek kodingan lagi       "                       ;
                }
                
                return "Terjadi kesalahan saat menghubungi server AI (Code: " . $response->status() . ").";
            }

            return "Maaf, tidak dapat menghubungi server AI setelah beberapa percobaan.";

        } catch (\Exception $e) {
            Log::error("AiBotService Exception: " . $e->getMessage());
            return "Maaf, terjadi kesalahan teknis pada chatbot. Silakan coba lagi nanti.";
        }
    }
}
