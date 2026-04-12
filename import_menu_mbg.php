<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

// Load Excel file
$spreadsheet = IOFactory::load('DAFTAR MENU MBG  (1).xlsx');
$sheet = $spreadsheet->getActiveSheet();
$data = $sheet->toArray();

// Connect to database
$host = '127.0.0.1';
$dbname = 'boto_delphi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Koneksi database berhasil\n\n";
    
    // Skip header rows (row 0, 1, 2)
    $imported = 0;
    $skipped = 0;
    
    for ($i = 3; $i < count($data); $i++) {
        $row = $data[$i];
        
        // Skip empty rows
        if (empty($row[0]) || $row[0] === null) {
            $skipped++;
            continue;
        }
        
        // Parse date
        $dateValue = $row[0];
        if (is_numeric($dateValue)) {
            // Excel date serial number
            $date = Date::excelToDateTimeObject($dateValue)->format('Y-m-d');
        } else {
            // String date format
            $date = date('Y-m-d', strtotime($dateValue));
        }
        
        $karbo = $row[1] ?? null;
        $protein_hewani = $row[2] ?? null;
        $protein_nabati = $row[3] ?? null;
        $sayur = $row[4] ?? null;
        $buah = $row[5] ?? null;
        $pelengkap = $row[6] ?? null;
        
        // Create menu content in JSON format
        $menuContent = [
            'karbo' => $karbo,
            'protein_hewani' => $protein_hewani,
            'protein_nabati' => $protein_nabati,
            'sayur' => $sayur,
            'buah' => $buah,
            'pelengkap' => $pelengkap
        ];
        
        $contentJson = json_encode($menuContent, JSON_UNESCAPED_UNICODE);
        
        // Check if menu already exists
        $check = $pdo->prepare("SELECT id FROM menus WHERE date = ?");
        $check->execute([$date]);
        
        if ($check->rowCount() > 0) {
            echo "⊘ Menu untuk tanggal $date sudah ada, dilewati\n";
            $skipped++;
            continue;
        }
        
        // Insert menu
        $sql = "INSERT INTO menus (
            date, 
            content,
            sppg_id,
            created_at,
            updated_at
        ) VALUES (?, ?, NULL, NOW(), NOW())";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $date,
            $contentJson
        ]);
        
        echo "✓ Imported: Menu $date\n";
        echo "  - Karbo: $karbo\n";
        echo "  - Protein Hewani: $protein_hewani\n";
        echo "  - Protein Nabati: $protein_nabati\n";
        echo "  - Sayur: $sayur\n";
        echo "  - Buah: $buah\n";
        if ($pelengkap) echo "  - Pelengkap: $pelengkap\n";
        echo "\n";
        
        $imported++;
    }
    
    echo "\n========================================\n";
    echo "SELESAI!\n";
    echo "========================================\n";
    echo "✓ Berhasil import: $imported menu\n";
    echo "⊘ Dilewati: $skipped baris\n";
    echo "========================================\n";
    
} catch (PDOException $e) {
    echo "✗ Error database: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
