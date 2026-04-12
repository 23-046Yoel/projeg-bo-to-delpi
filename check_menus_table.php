<?php

$pdo = new PDO("mysql:host=127.0.0.1;dbname=boto_delphi;charset=utf8mb4", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->query("DESCRIBE menus");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Struktur tabel menus:\n";
echo "=====================\n\n";

foreach ($columns as $col) {
    echo "- {$col['Field']} ({$col['Type']}) " . ($col['Null'] == 'YES' ? 'NULL' : 'NOT NULL') . "\n";
}
