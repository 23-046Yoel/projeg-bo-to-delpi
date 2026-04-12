<?php
/**
 * ====================================================
 * SCRIPT IMPORT RELAWAN - SPPG KARANGREJO
 * Upload ke: /home/aladelphi.or.id/public_html/public/import_karangrejo.php
 * Jalankan : https://aladelphi.or.id/import_karangrejo.php?key=fixboto2024
 * HAPUS SETELAH SELESAI!
 * ====================================================
 */

$secret = $_GET['key'] ?? '';
if ($secret !== 'fixboto2024') die('403 Forbidden');

echo '<pre style="background:#0d1117;color:#e6edf3;padding:20px;font-size:13px;font-family:monospace;">';
echo "<span style='color:#58a6ff'>👥 Import Relawan - SPPG Karangrejo</span>\n";
echo "=====================================\n\n";

$laravelRoot = '/home/aladelphi.or.id/public_html';
$env = file_get_contents($laravelRoot . '/.env');
preg_match('/DB_HOST=(.+)/',     $env, $m); $h = trim($m[1]);
preg_match('/DB_DATABASE=(.+)/', $env, $m); $d = trim($m[1]);
preg_match('/DB_USERNAME=(.+)/', $env, $m); $u = trim($m[1]);
preg_match('/DB_PASSWORD=(.*)/', $env, $m); $p = trim($m[1]);

$pdo = new PDO("mysql:host=$h;dbname=$d;charset=utf8mb4", $u, $p);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "<span style='color:#3fb950'>✅ Koneksi database berhasil!</span>\n\n";

// Cari SPPG Karangrejo
$stmt = $pdo->query("SELECT id, name FROM sppgs WHERE name LIKE '%Karang%' OR name LIKE '%karang%' LIMIT 1");
$sppg = $stmt->fetch(PDO::FETCH_ASSOC);
$sppgId = $sppg ? $sppg['id'] : null;
echo "SPPG: " . ($sppg ? $sppg['name'] . " (ID: $sppgId)" : "<span style='color:#e3b341'>Tidak ditemukan, sppg_id=NULL</span>") . "\n\n";

// Cek kolom sppg_id
$hasSppgId = $pdo->query("SHOW COLUMNS FROM `users` LIKE 'sppg_id'")->rowCount() > 0;

// Data 47 relawan SPPG Karangrejo
$relawan = [
    ['no'=>1,  'nama'=>'Fitriana',                   'phone'=>'083191283636'],
    ['no'=>2,  'nama'=>'Lenni Jumira Dewi',           'phone'=>'083867884196'],
    ['no'=>3,  'nama'=>'Lestari Darmayanti',          'phone'=>'083848562059'],
    ['no'=>4,  'nama'=>'Murniati',                    'phone'=>'083159982614'],
    ['no'=>5,  'nama'=>'Norma Yunita',                'phone'=>'081370825615'],
    ['no'=>6,  'nama'=>'Ria Misjayana',               'phone'=>'085270316367'],
    ['no'=>7,  'nama'=>'Sri Rahayu',                  'phone'=>'085261040585'],
    ['no'=>8,  'nama'=>'Wilda Rizky Aulia',           'phone'=>'085370069872'],
    ['no'=>9,  'nama'=>'Tino',                        'phone'=>'083137340845'],
    ['no'=>10, 'nama'=>'Dewi Mariam',                 'phone'=>'083863016606'],
    ['no'=>11, 'nama'=>'Ghubayani Pardede',           'phone'=>'082274402180'],
    ['no'=>12, 'nama'=>'Nila Kusuma',                 'phone'=>'083845133897'],
    ['no'=>13, 'nama'=>'Parti Alima',                 'phone'=>'083894331841'],
    ['no'=>14, 'nama'=>'Siti Sendari',                'phone'=>'081262175265'],
    ['no'=>15, 'nama'=>'Supia',                       'phone'=>'083195468226'],
    ['no'=>16, 'nama'=>'Triana Murni',                'phone'=>'083879922762'],
    ['no'=>17, 'nama'=>'Yusni Ade Yohana Saragih',   'phone'=>'082263486056'],
    ['no'=>18, 'nama'=>'Bella Cahaya',                'phone'=>'083876895211'],
    ['no'=>19, 'nama'=>'Johendri Damanik',            'phone'=>'082370330005'],
    ['no'=>20, 'nama'=>'Luvi Hazah Rindiani',         'phone'=>'087791053469'],
    ['no'=>21, 'nama'=>'Marwiyah',                    'phone'=>'082171308422'],
    ['no'=>22, 'nama'=>'Nasita',                      'phone'=>'081916553521'],
    ['no'=>23, 'nama'=>'Nur Asma Ambulani',           'phone'=>'081263057147'],
    ['no'=>24, 'nama'=>'Rumida',                      'phone'=>'081374366760'],
    ['no'=>25, 'nama'=>'Salma Wardah Lubis',          'phone'=>'089519191027'],
    ['no'=>26, 'nama'=>'Sunenti',                     'phone'=>'085296835976'],
    ['no'=>27, 'nama'=>'Umi Saidah',                  'phone'=>'081263303118'],
    ['no'=>28, 'nama'=>'Irvan Hasudungan Silalahi',   'phone'=>'082162999564'],
    ['no'=>29, 'nama'=>'Henry Hamonongan Siahaan',    'phone'=>'082272245693'],
    ['no'=>30, 'nama'=>'Roji Saputra',                'phone'=>'083155428836'],
    ['no'=>31, 'nama'=>'Ridho',                       'phone'=>'081226273024'],
    ['no'=>32, 'nama'=>'Bidol Tambunan',              'phone'=>'082273174847'],
    ['no'=>33, 'nama'=>'Evi Tamala Sari',             'phone'=>'081264063618'],
    ['no'=>34, 'nama'=>'Ika Nurlia',                  'phone'=>'085277552975'],
    ['no'=>35, 'nama'=>'Lailatul Mardiah',            'phone'=>'081260968703'],
    ['no'=>36, 'nama'=>'Marsaulina Simanjuntak',      'phone'=>'083115228687'],
    ['no'=>37, 'nama'=>'Musina',                      'phone'=>'083893361503'],
    ['no'=>38, 'nama'=>'Rimma Ida Mei Silalahi',      'phone'=>'081320567577'],
    ['no'=>39, 'nama'=>'Sartika',                     'phone'=>'082379715318'],
    ['no'=>40, 'nama'=>'Vety Lestari',                'phone'=>'083845660494'],
    ['no'=>41, 'nama'=>'Masiati',                     'phone'=>'082171308422'],
    ['no'=>42, 'nama'=>'Arsoyo',                      'phone'=>'081377819383'],
    ['no'=>43, 'nama'=>'Surobin',                     'phone'=>'082294220115'],
    ['no'=>44, 'nama'=>'Hermawan Ahmad Susilo',       'phone'=>'081377016718'],
    ['no'=>45, 'nama'=>'Marlina Samosir',             'phone'=>'081370494440'],
    ['no'=>46, 'nama'=>'Endang Mustika',              'phone'=>'082272839113'],
    ['no'=>47, 'nama'=>'Halimatusadiyah',             'phone'=>'082277386975'],
];

$imported = 0; $skipped = 0; $errors = 0;
$now = date('Y-m-d H:i:s');

echo "--- <span style='color:#ffa657'>PROSES IMPORT (47 Relawan Karangrejo)</span> ---\n";

foreach ($relawan as $r) {
    $phone = preg_replace('/[^0-9]/', '', $r['phone']);
    if (str_starts_with($phone, '0'))  $phone = '62' . substr($phone, 1);
    elseif (str_starts_with($phone, '8')) $phone = '62' . $phone;

    $nama  = $r['nama'];
    $slug  = strtolower(preg_replace('/[^a-z0-9]/i', '.', $nama));
    $email = $slug . '@karangrejo.aladelphi.or.id';

    // Cek duplikat by phone
    $chk = $pdo->prepare("SELECT id FROM users WHERE phone = ?");
    $chk->execute([$phone]);
    if ($chk->fetch()) {
        echo "  <span style='color:#8b949e'>⏭ #{$r['no']}: $nama (+$phone sudah ada)</span>\n";
        $skipped++;
        continue;
    }

    try {
        if ($hasSppgId) {
            $ins = $pdo->prepare("INSERT INTO users (name, email, phone, role, sppg_id, password, created_at, updated_at) VALUES (?,?,?,'volunteer',?,?,?,?)");
            $ins->execute([$nama, $email, $phone, $sppgId, password_hash(uniqid(), PASSWORD_BCRYPT), $now, $now]);
        } else {
            $ins = $pdo->prepare("INSERT INTO users (name, email, phone, role, password, created_at, updated_at) VALUES (?,?,?,'volunteer',?,?,?)");
            $ins->execute([$nama, $email, $phone, password_hash(uniqid(), PASSWORD_BCRYPT), $now, $now]);
        }
        echo "  <span style='color:#3fb950'>✅ #{$r['no']}: $nama | +$phone</span>\n";
        $imported++;
    } catch (Exception $e) {
        echo "  <span style='color:#f85149'>❌ #{$r['no']}: $nama | " . $e->getMessage() . "</span>\n";
        $errors++;
    }
}

// Ringkasan
echo "\n--- <span style='color:#ffa657'>HASIL AKHIR</span> ---\n";
echo "<span style='color:#3fb950'>✅ Berhasil import : $imported relawan</span>\n";
echo "<span style='color:#8b949e'>⏭  Skip (sudah ada): $skipped relawan</span>\n";
echo "<span style='color:#f85149'>❌ Error           : $errors relawan</span>\n";

$totalVol = $pdo->query("SELECT COUNT(*) FROM users WHERE role='volunteer'")->fetchColumn();
$totalAll = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
echo "\n<span style='color:#58a6ff'>Total volunteer di database : $totalVol orang</span>\n";
echo "<span style='color:#58a6ff'>Total semua user di database: $totalAll orang</span>\n";
echo "\n✅ Semua relawan bisa login di <b>https://aladelphi.or.id</b> dengan nomor WA!\n";
echo "\n<span style='color:#f85149'>⚠️  HAPUS file ini dari server setelah selesai!</span>\n";
echo '</pre>';
