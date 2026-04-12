<?php
/**
 * ====================================================
 * SCRIPT IMPORT RELAWAN - SPPG Balimbingan II
 * Upload ke: /home/aladelphi.or.id/public_html/public/import_relawan.php
 * Jalankan : https://aladelphi.or.id/import_relawan.php?key=fixboto2024
 * HAPUS SETELAH SELESAI!
 * ====================================================
 */

$secret = $_GET['key'] ?? '';
if ($secret !== 'fixboto2024') {
    die('403 Forbidden - Tambahkan ?key=fixboto2024 di URL');
}

echo '<pre style="background:#0d1117;color:#e6edf3;padding:20px;font-size:13px;font-family:monospace;">';
echo "<span style='color:#58a6ff'>👥 Import Relawan - SPPG Balimbingan II</span>\n";
echo "==========================================\n\n";

$laravelRoot = '/home/aladelphi.or.id/public_html';
$envContent  = file_get_contents($laravelRoot . '/.env');

preg_match('/DB_HOST=(.+)/',     $envContent, $m); $dbHost = trim($m[1] ?? '127.0.0.1');
preg_match('/DB_DATABASE=(.+)/', $envContent, $m); $dbName = trim($m[1] ?? '');
preg_match('/DB_USERNAME=(.+)/', $envContent, $m); $dbUser = trim($m[1] ?? '');
preg_match('/DB_PASSWORD=(.*)/', $envContent, $m); $dbPass = trim($m[1] ?? '');

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<span style='color:#3fb950'>✅ Koneksi database berhasil!</span>\n\n";
} catch (Exception $e) {
    die("<span style='color:#f85149'>❌ Koneksi GAGAL: " . $e->getMessage() . "</span>\n");
}

// Cari SPPG Balimbingan di database
$stmt = $pdo->query("SELECT id, name FROM sppgs WHERE name LIKE '%Balimbingan%' OR name LIKE '%balimbingan%' LIMIT 1");
$sppg = $stmt->fetch(PDO::FETCH_ASSOC);
$sppgId = $sppg ? $sppg['id'] : null;

echo "SPPG ditemukan: " . ($sppg ? $sppg['name'] . " (ID: $sppgId)" : "<span style='color:#e3b341'>Tidak ditemukan, sppg_id = NULL</span>") . "\n\n";

// Cek apakah kolom sppg_id ada di tabel users
$colCheck = $pdo->query("SHOW COLUMNS FROM `users` LIKE 'sppg_id'");
$hasSppgId = $colCheck->rowCount() > 0;

// Data relawan dari Excel (sudah diparsing manual)
$relawan = [
    ['no'=>1,  'nama'=>'Abraham Yesaya Sinurat',   'nik'=>'1208111410950004', 'phone'=>'089531422994', 'email'=>'Abraham01@gmail.com'],
    ['no'=>2,  'nama'=>'Agita Sebayang',            'nik'=>'1272066207940001', 'phone'=>'082217053980', 'email'=>'Agita.kaisar@gmail.com'],
    ['no'=>3,  'nama'=>'Abdi Septian',              'nik'=>'1208110910020003', 'phone'=>'082161772172', 'email'=>'abdiseptian1@gmail.com'],
    ['no'=>4,  'nama'=>'Arya',                      'nik'=>'1208111905040001', 'phone'=>'081262988244', 'email'=>'Arya.Ar@gmail.com'],
    ['no'=>5,  'nama'=>'Dedi Irawan',               'nik'=>'1208111712830002', 'phone'=>'085296244480', 'email'=>'Dedi.Irawan@gmail.com'],
    ['no'=>6,  'nama'=>'Diki Swendi',               'nik'=>'1208111512980002', 'phone'=>'082275480641', 'email'=>'Diki_Swendi@gmail.com'],
    ['no'=>7,  'nama'=>'Elya Sukesi',               'nik'=>'1208116904690003', 'phone'=>'082370316877', 'email'=>'Elya.sukesi@gmail.com'],
    ['no'=>8,  'nama'=>'Erni Yusnita Tambunan',     'nik'=>'1208116201850002', 'phone'=>'085261672945', 'email'=>'Erni_yusnitatam@gmail.com'],
    ['no'=>9,  'nama'=>'Ferlando Marpaung',         'nik'=>'1208111111010002', 'phone'=>'082272023756', 'email'=>'Ferlando.MarPaung@gmail.com'],
    ['no'=>10, 'nama'=>'Herliani Fitria Sari',      'nik'=>'1208114101830001', 'phone'=>'085296244480', 'email'=>'Herliani.Fitria@gmail.com'],
    ['no'=>11, 'nama'=>'Hotman Naibaho',            'nik'=>'1208110111640001', 'phone'=>'082276110617', 'email'=>'Hotman_Naibaho@gmail.com'],
    ['no'=>12, 'nama'=>'Irvan Sitorus',             'nik'=>'1215041506990002', 'phone'=>'082311338787', 'email'=>'Irvan_Sitorus@gmail.com'],
    ['no'=>13, 'nama'=>'Jondi Sirait',              'nik'=>'1208110607720001', 'phone'=>'081263150907', 'email'=>'Jondi_Sirait@gmail.com'],
    ['no'=>14, 'nama'=>'Lamhot Sirait',             'nik'=>'1208110903700003', 'phone'=>'085370534481', 'email'=>'Lamhot.Sirait@gmail.com'],
    ['no'=>15, 'nama'=>'Mardiani Sirait',           'nik'=>'1208116412890002', 'phone'=>'082277077474', 'email'=>'Mardiani.Sirait@gmail.com'],
    ['no'=>16, 'nama'=>'Marulam Banurea',           'nik'=>'1208111202870003', 'phone'=>'081265086636', 'email'=>'Marulam.Banurea@gmail.com'],
    ['no'=>17, 'nama'=>'Naulicen Sihombing',        'nik'=>'1208115208800001', 'phone'=>'081261097701', 'email'=>'Naulicen.Sihombing@gmail.com'],
    ['no'=>18, 'nama'=>'Nurliana',                  'nik'=>'1208116004790001', 'phone'=>'085361226490', 'email'=>'Nurliana01@gmail.com'],
    ['no'=>19, 'nama'=>'Parlaungan Saragih',        'nik'=>'1208110801820007', 'phone'=>'082272024780', 'email'=>'Parlaungan.saragih@gmail.com'],
    ['no'=>20, 'nama'=>'Rahmat Efendi Sirait',      'nik'=>'1208111108940006', 'phone'=>'085275143059', 'email'=>'Rahmat_Efendi@gmail.com'],
    ['no'=>21, 'nama'=>'Ridho Syahputra',           'nik'=>'1208111601040002', 'phone'=>'082272023756', 'email'=>'Ridho.Syah01@gmail.com'],
    ['no'=>22, 'nama'=>'Riski Efrianto',            'nik'=>'1208111906010001', 'phone'=>'082272022754', 'email'=>'Riski.Efrianto@gmail.com'],
    ['no'=>23, 'nama'=>'Roni Manurung',             'nik'=>'1208114004810003', 'phone'=>'081370074891', 'email'=>'Roni_Manurung@gmail.com'],
    ['no'=>24, 'nama'=>'Rudianto Purba',            'nik'=>'1208111002010002', 'phone'=>'085261082699', 'email'=>'Rudianto.Purba@gmail.com'],
    ['no'=>25, 'nama'=>'Sengketa Sinaga',           'nik'=>'1208112110940002', 'phone'=>'081375285788', 'email'=>'Sengketa.Sinaga@gmail.com'],
    ['no'=>26, 'nama'=>'Seri Wardini',              'nik'=>'1208116606820001', 'phone'=>'082272093534', 'email'=>'Seri.Wardini@gmail.com'],
    ['no'=>27, 'nama'=>'Sihar Mangisi Simbolon',    'nik'=>'1208110502010001', 'phone'=>'082370131793', 'email'=>'Sihar.Simbolon@gmail.com'],
    ['no'=>28, 'nama'=>'Sos Arianto Purba',         'nik'=>'1208111603830002', 'phone'=>'082370013290', 'email'=>'Sos.Arianto@gmail.com'],
    ['no'=>29, 'nama'=>'Sunarno',                   'nik'=>'1208111712690004', 'phone'=>'085277134562', 'email'=>'Sunarno01@gmail.com'],
    ['no'=>30, 'nama'=>'Supriadi Tarigan',          'nik'=>'1208111407820001', 'phone'=>'082370316877', 'email'=>'Supriadi.Tarigan@gmail.com'],
    ['no'=>31, 'nama'=>'Syahria Sari Nasution',     'nik'=>'1208116607850002', 'phone'=>'082272024780', 'email'=>'Syahria.Sari@gmail.com'],
    ['no'=>32, 'nama'=>'Tari Indriyani',            'nik'=>'1208116507000001', 'phone'=>'082272093534', 'email'=>'Tari.Indriyani@gmail.com'],
    ['no'=>33, 'nama'=>'Tommy Simbolon',            'nik'=>'1208110908970001', 'phone'=>'081263150907', 'email'=>'Tommy.Simbolon@gmail.com'],
    ['no'=>34, 'nama'=>'Wahyudi',                   'nik'=>'1208111402910006', 'phone'=>'082276110617', 'email'=>'Wahyudi01@gmail.com'],
    ['no'=>35, 'nama'=>'Winda Karolina Sitanggang', 'nik'=>'1208116207940002', 'phone'=>'085261082699', 'email'=>'Winda.Karolina@gmail.com'],
    ['no'=>36, 'nama'=>'Wira Dharma Sinaga',        'nik'=>'1208112101000002', 'phone'=>'082311338787', 'email'=>'Wira.Dharma@gmail.com'],
    ['no'=>37, 'nama'=>'Yogi Febriandi Tarigan',    'nik'=>'1208112601000001', 'phone'=>'085296244480', 'email'=>'Yogi.Febriandi@gmail.com'],
    ['no'=>38, 'nama'=>'Yusnita Saragih',           'nik'=>'1208116802870001', 'phone'=>'081362083376', 'email'=>'Yusnita.Saragih@gmail.com'],
    ['no'=>39, 'nama'=>'Zulkifli Harahap',          'nik'=>'1208111601870004', 'phone'=>'085370534481', 'email'=>'Zulkifli.Harahap@gmail.com'],
    ['no'=>40, 'nama'=>'Zurayda',                   'nik'=>'1208116205780001', 'phone'=>'082275480641', 'email'=>'Zurayda01@gmail.com'],
];

$imported = 0;
$skipped  = 0;
$errors   = 0;
$now = date('Y-m-d H:i:s');

echo "--- <span style='color:#ffa657'>PROSES IMPORT DATA RELAWAN</span> ---\n";

foreach ($relawan as $r) {
    $phone = preg_replace('/[^0-9]/', '', $r['phone']);
    if (str_starts_with($phone, '0')) $phone = '62' . substr($phone, 1);
    elseif (str_starts_with($phone, '8')) $phone = '62' . $phone;

    $email = $r['email'];
    $nama  = $r['nama'];

    // Cek duplikat
    $chk = $pdo->prepare("SELECT id FROM users WHERE phone = ? OR email = ?");
    $chk->execute([$phone, $email]);
    if ($chk->fetch()) {
        echo "  <span style='color:#8b949e'>⏭ #{$r['no']}: $nama (sudah ada)</span>\n";
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

echo "\n--- <span style='color:#ffa657'>HASIL AKHIR</span> ---\n";
echo "<span style='color:#3fb950'>✅ Berhasil import : $imported relawan</span>\n";
echo "<span style='color:#8b949e'>⏭  Skip (sudah ada): $skipped relawan</span>\n";
echo "<span style='color:#f85149'>❌ Error           : $errors relawan</span>\n";

$total = $pdo->query("SELECT COUNT(*) FROM users WHERE role='volunteer'")->fetchColumn();
echo "\n<span style='color:#58a6ff'>Total volunteer di database sekarang: $total orang</span>\n";
echo "\n✅ Semua relawan bisa login di <b>https://aladelphi.or.id</b> dengan nomor WA masing-masing!\n";
echo "\n<span style='color:#f85149'>⚠️  HAPUS file ini dari server setelah selesai!</span>\n";
echo '</pre>';
