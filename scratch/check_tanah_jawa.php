<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$searchTerm = 'Tanah Jawa';

$file = 'Daftar (1).xlsx';
$filePath = __DIR__ . '/../' . $file;

if (!file_exists($filePath)) {
    die("File not found.\n");
}

try {
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray(null, true, true, true);
    
    echo "Results for '$searchTerm':\n";
    foreach ($data as $rowIndex => $row) {
        $rowStr = implode(' | ', array_map(function($v) { return (string)$v; }, $row));
        if (stripos($rowStr, $searchTerm) !== false) {
            echo "Row $rowIndex: $rowStr\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
