<?php
/**
 * Script debug: Test Gemini API langsung
 * Jalankan: php scratch/test_gemini.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$apiKey = config('services.gemini.key');

echo "=== DEBUG GEMINI API ===\n";
echo "API Key: " . (!empty($apiKey) ? substr($apiKey, 0, 10) . "..." : "TIDAK ADA!") . "\n\n";

if (empty($apiKey)) {
    echo "ERROR: GEMINI_API_KEY tidak ditemukan di .env!\n";
    exit(1);
}

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}";

$payload = [
    'contents' => [
        [
            'role' => 'user',
            'parts' => [['text' => 'Halo, ini test. Jawab singkat saja: siapa kamu?']]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.7,
        'maxOutputTokens' => 100,
    ]
];

echo "Memanggil Gemini API...\n";

$response = \Illuminate\Support\Facades\Http::timeout(30)
    ->withHeaders(['Content-Type' => 'application/json'])
    ->post($url, $payload);

echo "Status HTTP: " . $response->status() . "\n";
echo "Response body:\n" . $response->body() . "\n\n";

if ($response->successful()) {
    $data = $response->json();
    $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'TIDAK ADA TEKS';
    echo "✅ SUKSES! Jawaban AI:\n" . $text . "\n";
} else {
    echo "❌ GAGAL! Status: " . $response->status() . "\n";
    echo "Error: " . $response->body() . "\n";
    
    // Coba model lain (gemini-1.5-pro)
    echo "\n--- Mencoba gemini-1.5-pro ---\n";
    $url2 = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent?key={$apiKey}";
    $response2 = \Illuminate\Support\Facades\Http::timeout(30)
        ->withHeaders(['Content-Type' => 'application/json'])
        ->post($url2, $payload);
    echo "Status: " . $response2->status() . "\n";
    echo "Body: " . $response2->body() . "\n";
    
    // Coba model gemini-2.0-flash
    echo "\n--- Mencoba gemini-2.0-flash ---\n";
    $url3 = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";
    $response3 = \Illuminate\Support\Facades\Http::timeout(30)
        ->withHeaders(['Content-Type' => 'application/json'])
        ->post($url3, $payload);
    echo "Status: " . $response3->status() . "\n";
    echo "Body: " . $response3->body() . "\n";
}
