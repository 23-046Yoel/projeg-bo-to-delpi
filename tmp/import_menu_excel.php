<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;
use App\Models\Sppg;
use Illuminate\Support\Facades\DB;

$spreadsheet = IOFactory::load(__DIR__ . '/DAFTAR MENU MBG  (1).xlsx');
$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray();

// Get the SPPG id (default to 2 = Karang Rejo)
$sppg = Sppg::where('name', 'like', '%Karang Rejo%')->first();
$sppg_id = $sppg ? $sppg->id : 2;

$imported = 0;
$skipped = 0;

foreach ($rows as $i => $row) {
    // Skip header rows
    if ($i < 3) continue;
    if (empty($row[0])) continue;

    // Parse date
    $dateRaw = $row[0];
    try {
        $date = \Carbon\Carbon::parse($dateRaw)->format('Y-m-d');
    } catch (\Exception $e) {
        echo "Skip row $i: invalid date '$dateRaw'" . PHP_EOL;
        $skipped++;
        continue;
    }

    $karbo          = $row[1] ?? null;
    $protein_hewani = $row[2] ?? null;
    $protein_nabati = $row[3] ?? null;
    $sayur          = $row[4] ?? null;
    $buah           = $row[5] ?? null;
    $pelengkap      = $row[6] ?? null;

    $content = "Karbo: $karbo | Protein Hewani: $protein_hewani | Protein Nabati: $protein_nabati | Sayur: $sayur | Buah: $buah | Pelengkap: $pelengkap";

    // Check if menu for this date already exists
    $existing = Menu::where('date', $date)->where('sppg_id', $sppg_id)->first();

    if ($existing) {
        $existing->update([
            'content'       => $content,
            'karbo'         => $karbo,
            'protein_hewani'=> $protein_hewani,
            'protein_nabati'=> $protein_nabati,
            'sayur'         => $sayur,
            'buah'          => $buah,
            'pelengkap'     => $pelengkap,
        ]);
        echo "Updated: $date" . PHP_EOL;
    } else {
        Menu::create([
            'date'          => $date,
            'sppg_id'       => $sppg_id,
            'content'       => $content,
            'karbo'         => $karbo,
            'protein_hewani'=> $protein_hewani,
            'protein_nabati'=> $protein_nabati,
            'sayur'         => $sayur,
            'buah'          => $buah,
            'pelengkap'     => $pelengkap,
        ]);
        echo "Inserted: $date" . PHP_EOL;
    }
    $imported++;
}

echo PHP_EOL . "Selesai! $imported menu berhasil diimport. $skipped dilewati." . PHP_EOL;
