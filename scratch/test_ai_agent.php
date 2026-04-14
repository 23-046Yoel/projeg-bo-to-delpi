<?php
/**
 * Test AiBotService TANPA koneksi DB (tidak perlu Laragon nyala)
 */
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TEST AI AGENT (tanpa DB) ===\n\n";

$ai = app(\App\Services\AiBotService::class);

// Context manual (simulasi data menu)
$context  = "=== SISTEM BoTo Delphi — Program MBG Alad Elphi ===\n";
$context .= "Website: https://aladelphi.or.id\n";
$context .= "Tanggal hari ini: Senin, 14 April 2026\n\n";
$context .= "JADWAL MENU MBG:\n";
$context .= "📅 Senin, 14 April 2026 [HARI INI] | Dapur: SPPG Balimbingan\n";
$context .= "   Karbo: Nasi Putih | Protein Hewani: Ayam Bumbu Kuning | Sayur: Tumis Kangkung | Buah: Pisang\n\n";
$context .= "📅 Selasa, 15 April 2026 | Dapur: SPPG Balimbingan\n";
$context .= "   Karbo: Nasi Merah | Protein Hewani: Ikan Goreng | Sayur: Sayur Asem | Buah: Jeruk\n\n";
$context .= "FORMULIR:\n";
$context .= "- Jadwal Menu Lengkap: https://aladelphi.or.id/jadwal-menu\n";
$context .= "- Pengaduan: https://aladelphi.or.id/complaints/create\n";
$context .= "- Daftar Pemasok: https://aladelphi.or.id/pendaftaran-pemasok\n";

$pertanyaans = [
    "Menu hari ini apa?",
    "Gimana cara daftar jadi pemasok?",
    "Saya mau lapor, anak saya tidak dapat jatah makan",
    "Menu besok apa?",
];

foreach ($pertanyaans as $i => $q) {
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "❓ [" . ($i+1) . "] $q\n";
    echo "🤖 AI: ";
    echo $ai->generateResponse($q, $context, 'TestUser') . "\n\n";
}

echo "✅ Groq AI berjalan sempurna!\n";
