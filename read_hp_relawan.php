<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = IOFactory::load('DATA NOMOR HP RELAWAN.xlsx');
$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray();

echo "Total rows: " . count($rows) . "\n\n";
foreach ($rows as $i => $row) {
    echo "Row $i: " . implode(' | ', array_map('strval', $row)) . "\n";
    if ($i >= 60) { echo "...dst (total " . count($rows) . " baris)\n"; break; }
}
