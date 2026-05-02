<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

try {
    $spreadsheet = IOFactory::load('DAFTAR MENU MBG  (1).xlsx');
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();
    
    echo "Listing first 10 dates:\n";
    $count = 0;
    foreach ($data as $i => $row) {
        if ($i < 3) continue;
        if (empty($row[0])) continue;
        $dateValue = $row[0];
        if (is_numeric($dateValue)) {
            $date = Date::excelToDateTimeObject($dateValue)->format('Y-m-d');
        } else {
            $date = date('Y-m-d', strtotime($dateValue));
        }
        echo "- $date\n";
        if (++$count >= 10) break;
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
