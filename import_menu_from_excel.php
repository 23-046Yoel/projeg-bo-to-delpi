<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

// Bootstrap Laravel from root directory
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;
use App\Models\Sppg;

$spreadsheet = IOFactory::load(__DIR__ . '/DAFTAR MENU MBG  (1).xlsx');
$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray();

$sppg = Sppg::where('name', 'like', '%Karang Rejo%')->first();
$sppg_id = $sppg ? $sppg->id : 2;

$imported = 0;

foreach ($rows as $i => $row) {
    if ($i < 3) continue; // Skip header rows
    if (empty($row[0])) continue;

    try {
        $date = \Carbon\Carbon::parse($row[0])->format('Y-m-d');
    } catch (\Exception $e) {
        echo "Skip row $i: invalid date\n";
        continue;
    }

    $data = [
        'sppg_id'        => $sppg_id,
        'karbo'          => $row[1] ?? null,
        'protein_hewani' => $row[2] ?? null,
        'protein_nabati' => $row[3] ?? null,
        'sayur'          => $row[4] ?? null,
        'buah'           => $row[5] ?? null,
        'pelengkap'      => $row[6] ?? null,
        'content'        => implode(' | ', array_filter(array_slice($row, 1, 6))),
    ];

    Menu::updateOrCreate(['date' => $date, 'sppg_id' => $sppg_id], $data);
    echo "OK: $date - {$data['karbo']}\n";
    $imported++;
}

echo "\nSelesai! $imported menu berhasil diimport.\n";
