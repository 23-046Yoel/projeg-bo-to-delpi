<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$key = config('services.groq.key');
echo "Groq Key: " . (!empty($key) ? substr($key, 0, 15) . "..." : "TIDAK ADA") . "\n";

$url = 'https://api.groq.com/openai/v1/chat/completions';
$r = \Illuminate\Support\Facades\Http::timeout(20)
    ->withHeaders([
        'Authorization' => 'Bearer ' . $key,
        'Content-Type'  => 'application/json'
    ])
    ->post($url, [
        'model'    => 'llama-3.3-70b-versatile',
        'messages' => [
            ['role' => 'system', 'content' => 'Kamu adalah asisten BoTo Delphi untuk program MBG.'],
            ['role' => 'user',   'content' => 'Menu MBG hari ini apa? Jawab singkat saja.']
        ],
        'max_tokens' => 100
    ]);

echo "Status: " . $r->status() . "\n";

if ($r->successful()) {
    echo "✅ Groq BERHASIL!\n";
    echo "Jawaban: " . $r->json()['choices'][0]['message']['content'] . "\n";
} else {
    echo "❌ Groq GAGAL!\n";
    echo "Error: " . $r->body() . "\n";
}
