<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$searchTerm = 'Meylinda';
$phoneTerm = '88260013607';

$files = [
    'Daftar (1).xlsx',
    'DATA NOMOR HP RELAWAN.xlsx'
];

foreach ($files as $file) {
    $filePath = __DIR__ . '/../' . $file;
    echo "--- Checking file: $file ---\n";
    if (!file_exists($filePath)) {
        echo "File not found.\n\n";
        continue;
    }

    try {
        $spreadsheet = IOFactory::load($filePath);
        foreach ($spreadsheet->getAllSheets() as $sheet) {
            echo "Sheet: " . $sheet->getTitle() . "\n";
            $data = $sheet->toArray(null, true, true, true);
            foreach ($data as $rowIndex => $row) {
                $rowStr = implode(' | ', array_map(function($v) { return (string)$v; }, $row));
                if (stripos($rowStr, $searchTerm) !== false || strpos(str_replace(['-', ' ', '+'], '', $rowStr), $phoneTerm) !== false) {
                    echo "Found at Row $rowIndex: $rowStr\n";
                }
            }
        }
    } catch (\Exception $e) {
        echo "Error reading file: " . $e->getMessage() . "\n";
    }
    echo "\n";
}
