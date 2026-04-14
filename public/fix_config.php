<?php
/**
 * Update ENV and Clear Cache on Server (Secret-safe version)
 */
$key = $_GET['key'] ?? '';
$newGroq = $_GET['groq_key'] ?? '';

if ($key !== 'sync2024' || !$newGroq) {
    die('Unauthorized access or missing groq_key parameter.');
}

$path = dirname(__DIR__) . '/.env';
if (!file_exists($path)) {
    die('.env file not found.');
}

$content = file_get_contents($path);

// Update Groq Key (lebih aman pakai regex)
if (strpos($content, 'GROQ_API_KEY=') !== false) {
    $content = preg_replace('/GROQ_API_KEY=.*/', 'GROQ_API_KEY=' . $newGroq, $content);
} else {
    $content .= "\nGROQ_API_KEY=" . $newGroq;
}

file_put_contents($path, $content);

echo "✅ <b>Configuration Updated!</b><br>";
echo "Groq API Key has been set. Please try WhatsApp now.";
