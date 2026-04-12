<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = IOFactory::load('DAFTAR MENU MBG  (1).xlsx');
$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray();

echo "Total rows: " . count($rows) . PHP_EOL;
foreach (array_slice($rows, 0, 30) as $i => $row) {
    $clean = array_filter($row, fn($v) => $v !== null && $v !== '');
    if (!empty($clean)) {
        echo "Row $i: " . json_encode(array_values($row), JSON_UNESCAPED_UNICODE) . PHP_EOL;
    }
}
