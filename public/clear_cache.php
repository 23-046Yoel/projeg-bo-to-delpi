<?php
/**
 * BO TO DELPHI - ADVANCED SERVER CONTROL PANEL
 * Lokasi: public/clear_cache.php
 */

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\File;

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

// LOGIKA ACTION
$message = "";
$action = $_GET['action'] ?? null;

if ($action === 'mati') {
    try {
        Artisan::call('down', ['--secret' => 'aladelphi-admin']);
        $message = ["success", "Website Berhasil DIMATIKAN!"];
    } catch (\Exception $e) { $message = ["error", $e->getMessage()]; }
} elseif ($action === 'hidup') {
    try {
        Artisan::call('up');
        $message = ["success", "Website Berhasil DIHIDUPKAN!"];
    } catch (\Exception $e) { $message = ["error", $e->getMessage()]; }
} elseif ($action === 'clear') {
    try {
        Artisan::call('optimize:clear');
        $message = ["success", "Semua Cache Berhasil DIBERSIHKAN!"];
    } catch (\Exception $e) { $message = ["error", $e->getMessage()]; }
} elseif ($action === 'pull') {
    $out = shell_exec("git pull origin main 2>&1");
    $message = ["info", "Git Pull Result: <br><pre style='font-size:12px; margin-top:10px;'>$out</pre>"];
}

// CEK STATUS MAINTENANCE
$isDown = file_exists(storage_path('framework/down'));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Control Panel | Bo To Delphi</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --success: #22c55e;
            --danger: #ef4444;
            --bg: #0f172a;
            --card: rgba(30, 41, 59, 0.7);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Outfit', sans-serif; 
            background: var(--bg); 
            color: white; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: radial-gradient(circle at 20% 30%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                              radial-gradient(circle at 80% 70%, rgba(239, 68, 68, 0.1) 0%, transparent 50%);
        }

        .container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        .panel {
            background: var(--card);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(to right, #818cf8, #f472b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 32px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 32px;
            gap: 8px;
        }

        .status-online { background: rgba(34, 197, 94, 0.1); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.2); }
        .status-offline { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }

        .pulse {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            animation: pulse-animation 2s infinite;
        }

        @keyframes pulse-animation {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.2); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(255, 255, 255, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 10px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(255, 255, 255, 0.03);
            color: white;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            gap: 8px;
        }

        .btn:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .btn-main { grid-column: span 2; background: var(--primary); font-weight: 600; border: none; }
        .btn-main:hover { background: #4f46e5; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4); }

        .btn-mati { color: #f87171; }
        .btn-hidup { color: #4ade80; }

        .btn i { font-size: 20px; margin-bottom: 4px; }
        .btn span { font-size: 12px; opacity: 0.8; }

        .alert {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            line-height: 1.5;
            animation: slideDown 0.4s ease;
        }
        .alert-success { background: rgba(34, 197, 94, 0.1); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.2); }
        .alert-error { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }
        .alert-info { background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.2); text-align: left; }

        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        .footer-link {
            display: block;
            margin-top: 24px;
            color: #64748b;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.3s;
        }
        .footer-link:hover { color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="panel">
        <div class="logo">BO TO DELPHI</div>
        <div class="subtitle">Advanced Server Manager</div>

        <?php if ($message): ?>
            <div class="alert alert-<?= $message[0] ?>">
                <?= $message[1] ?>
            </div>
        <?php endif; ?>

        <div class="status-badge <?= $isDown ? 'status-offline' : 'status-online' ?>">
            <div class="pulse"></div>
            <?= $isDown ? 'WEBSITE: MAINTENANCE MODE' : 'WEBSITE: ONLINE' ?>
        </div>

        <div class="grid">
            <?php if (!$isDown): ?>
                <a href="?action=mati" class="btn btn-mati" onclick="return confirm('Matikan website?')">
                    <strong>🛑 Matikan</strong>
                    <span>Maintenance Mode</span>
                </a>
            <?php else: ?>
                <a href="?action=hidup" class="btn btn-hidup">
                    <strong>🚀 Hidupkan</strong>
                    <span>Go Live Now</span>
                </a>
            <?php endif; ?>

            <a href="?action=clear" class="btn">
                <strong>🧹 Clean Cache</strong>
                <span>Clear Artisan</span>
            </a>

            <a href="?action=pull" class="btn btn-main">
                <strong>🔄 Update Source Code</strong>
                <span>Git Pull Origin Main</span>
            </a>
        </div>

        <a href="/" class="footer-link">← Kembali ke Website Utama</a>
        <p style="font-size: 10px; color: #475569; margin-top: 20px; opacity: 0.5;">Authorized Access Only • v2.1</p>
    </div>
</div>

</body>
</html>
