<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

try {
    $spreadsheet = IOFactory::load('Daftar (1).xlsx');
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray(null, true, true, true);
    print_r(array_slice($data, 0, 20)); // Show top 20 rows
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
