<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$service = new App\Services\AiBotService();
$response = $service->generateResponse("Halo, siapa kamu?", "Test context");

echo "Response from AI: " . $response . "\n";
