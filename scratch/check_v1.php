<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = config('services.gemini.key');
$url = "https://generativelanguage.googleapis.com/v1/models?key=" . $apiKey;

$response = Illuminate\Support\Facades\Http::get($url);

if ($response->successful()) {
    echo json_encode($response->json(), JSON_PRETTY_PRINT);
} else {
    echo "Error [" . $response->status() . "]: " . $response->body();
}
