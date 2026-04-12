<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

try {
    $spreadsheet = IOFactory::load('DAFTAR MENU MBG  (1).xlsx');
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();
    
    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
