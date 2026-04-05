# ============================================================
#  SCRIPT : Jalankan Project Laravel + Ngrok
#  Project: projeg Bo To Delpi (MBG Admin & Financial System)
#  Cara   : Klik kanan file ini > "Run with PowerShell"
#           atau jalankan di terminal:run 
#           powershell -ExecutionPolicy Bypass -File "jalankan-dengan-ngrok.ps1"
# ============================================================

# ── Konfigurasi ──────────────────────────────────────────────
$PROJECT_PATH   = "c:\laragon\www\projeg Bo To Delpi"
$LARAGON_DOMAIN = "projeg-bo-to-delpi.test"
$NGROK_PORT_WEB = 80          # port Laragon web server
$NGROK_PORT_APP = 8000        # port php artisan serve (fallback)
$WAIT_NGROK     = 4           # detik tunggu ngrok siap
$ENV_FILE       = "$PROJECT_PATH\.env"

# ── Warna helper ─────────────────────────────────────────────
function Title($m)  { Write-Host "`n$m" -ForegroundColor Yellow }
function Step($m)   { Write-Host "  >> $m" -ForegroundColor Cyan }
function OK($m)     { Write-Host "  [OK]    $m" -ForegroundColor Green }
function Warn($m)   { Write-Host "  [WARN]  $m" -ForegroundColor DarkYellow }
function Err($m)    { Write-Host "  [ERROR] $m" -ForegroundColor Red }
function Info($m)   { Write-Host "  [INFO]  $m" -ForegroundColor Gray }

# ── Banner ───────────────────────────────────────────────────
Clear-Host
Write-Host @"
  +----------------------------------------------------------+
  |   MBG Admin & Financial System - Laravel + Ngrok       |
  |       projeg Bo To Delpi                                 |
  +----------------------------------------------------------+
"@ -ForegroundColor Yellow

# -----------------------------------------------------------
# LANGKAH 1 — Cari PHP
# -----------------------------------------------------------
Step "Mencari PHP..."
$phpPath = $null
$phpCandidates = @(
    "C:\laragon\bin\php\php8.2.26\php.exe",
    "C:\laragon\bin\php\php8.2.0\php.exe",
    "C:\laragon\bin\php\php8.1.10\php.exe",
    "C:\laragon\bin\php\php8.1.0\php.exe",
    "C:\laragon\bin\php\php8.0.0\php.exe",
    "C:\laragon\bin\php\php7.4.33\php.exe",
    "C:\laragon\bin\php\php7.4.0\php.exe"
)
foreach ($p in $phpCandidates) {
    if (Test-Path $p) { $phpPath = $p; break }
}
if (-not $phpPath) {
    # coba dari PATH sistem
    $phpInPath = (Get-Command php -ErrorAction SilentlyContinue)
    if ($phpInPath) { $phpPath = $phpInPath.Source }
}
if (-not $phpPath) {
    Err "PHP tidak ditemukan! Pastikan Laragon sudah terinstall."
    Read-Host "Tekan Enter untuk keluar"; exit 1
}
OK "PHP ditemukan: $phpPath"
$phpVer = & $phpPath -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;" 2>$null
Info "Versi PHP: $phpVer"

# -----------------------------------------------------------
# LANGKAH 2 — Cari Ngrok
# -----------------------------------------------------------
Step "Mencari Ngrok..."
$ngrokPath = $null
$ngrokCandidates = @(
    "C:\ngrok\ngrok.exe",
    "C:\tools\ngrok\ngrok.exe",
    "$env:USERPROFILE\ngrok.exe",
    "$env:USERPROFILE\Downloads\ngrok.exe",
    "$env:LOCALAPPDATA\ngrok\ngrok.exe",
    "C:\Windows\ngrok.exe",
    "C:\Windows\System32\ngrok.exe"
)
foreach ($loc in $ngrokCandidates) {
    if (Test-Path $loc) { $ngrokPath = $loc; break }
}
if (-not $ngrokPath) {
    $ngInPath = (Get-Command ngrok -ErrorAction SilentlyContinue)
    if ($ngInPath) { $ngrokPath = $ngInPath.Source }
}

$useNgrok = $false
if ($ngrokPath) {
    OK "Ngrok ditemukan: $ngrokPath"
    $useNgrok = $true
} else {
    Warn "Ngrok tidak ditemukan di komputer ini."
    Write-Host ""
    Write-Host "  Cara install Ngrok:" -ForegroundColor White
    Write-Host "  1. Download  : https://ngrok.com/download" -ForegroundColor White
    Write-Host "  2. Ekstrak   : ngrok.exe ke folder C:\ngrok\" -ForegroundColor White
    Write-Host "  3. Daftar    : https://dashboard.ngrok.com" -ForegroundColor White
    Write-Host "  4. Auth token: ngrok config add-authtoken <TOKEN_ANDA>" -ForegroundColor White
    Write-Host ""
    $ans = Read-Host "  Lanjutkan tanpa ngrok (akses lokal saja)? [y/N]"
    if ($ans.ToLower() -ne 'y') { exit 1 }
}

# -----------------------------------------------------------
# LANGKAH 3 — Masuk direktori project
# -----------------------------------------------------------
Step "Masuk ke direktori project..."
if (-not (Test-Path $PROJECT_PATH)) {
    Err "Folder project tidak ditemukan: $PROJECT_PATH"
    Read-Host "Tekan Enter untuk keluar"; exit 1
}
Set-Location $PROJECT_PATH
OK "Berada di: $PROJECT_PATH"

# -----------------------------------------------------------
# LANGKAH 4 — Cek file .env
# -----------------------------------------------------------
Step "Mengecek file .env..."
if (-not (Test-Path $ENV_FILE)) {
    Warn ".env tidak ada! Menyalin dari .env.example..."
    if (Test-Path "$PROJECT_PATH\.env.example") {
        Copy-Item "$PROJECT_PATH\.env.example" $ENV_FILE
        OK ".env berhasil dibuat dari .env.example"
        & $phpPath artisan key:generate --ansi 2>&1 | Out-Null
        OK "APP_KEY berhasil di-generate"
    } else {
        Err ".env.example juga tidak ada! Buat file .env terlebih dahulu."
        Read-Host "Tekan Enter untuk keluar"; exit 1
    }
} else {
    OK ".env ditemukan"
}

# -----------------------------------------------------------
# LANGKAH 5 — Bersihkan cache Laravel
# -----------------------------------------------------------
Step "Membersihkan cache Laravel (Optimize)..."
& $phpPath artisan optimize:clear 2>&1 | Out-Null
OK "Cache Laravel dibersihkan (Config, Route, View, Compiled)"

# -----------------------------------------------------------
# LANGKAH 5.2 — Pastikan Aset Produksi (Hapus file 'hot')
# -----------------------------------------------------------
Step "Membersihkan file Vite dev server (public/hot)..."
if (Test-Path "public/hot") {
    Remove-Item "public/hot" -Force
    OK "File 'public/hot' dihapus (memaksa Laravel pakai aset hasil build)"
} else {
    Info "File 'public/hot' tidak ada, sudah bersih."
}


# -----------------------------------------------------------
# LANGKAH 5.5 — Build Aset (Vite)
# -----------------------------------------------------------
Step "Mengecek aset statis..."
if (Test-Path "public/build/manifest.json") {
    OK "Aset produksi ditemukan di public/build/. Melewati build untuk menghemat waktu."
    Info "Jika ada perubahan CSS/JS, hapus folder public/build/ atau jalankan 'npm run build' manual."
} elseif (Test-Path "package.json") {
    Warn "Aset produksi tidak ditemukan. Membangun aset (npm run build)..."
    npm run build
    if ($LASTEXITCODE -ne 0) {
        Err "Build aset gagal! Periksa file CSS/JS Anda."
        Read-Host "Tekan Enter untuk tetap lanjut atau CTRL+C untuk berhenti"
    } else {
        OK "Aset berhasil di-build"
    }
} else {
    Warn "package.json tidak ditemukan, lewati build aset."
}


# -----------------------------------------------------------
# LANGKAH 6 — Cek apakah Laragon Web Server aktif
# -----------------------------------------------------------
# Skip Laragon check to avoid landing page issue, go straight to artisan serve
$runPhpServer = $true
$localUrl     = "" # Initialize $localUrl here as it's used later
$ngrokTarget  = $NGROK_PORT_APP # Force ngrok to target artisan serve port

if ($runPhpServer) {
    Warn "Laragon web server tidak aktif. Menggunakan php artisan serve..."
    Step "Menjalankan php artisan serve (port $NGROK_PORT_APP)..."
    # Hentikan proses php-artisan-serve yang mungkin masih berjalan
    Get-Process -Name "php" -ErrorAction SilentlyContinue |
        Where-Object { $_.CommandLine -like "*artisan*serve*" } |
        Stop-Process -Force -ErrorAction SilentlyContinue

    $phpServerProc = Start-Process `
        -FilePath $phpPath `
        -ArgumentList "artisan", "serve", "--host=0.0.0.0", "--port=$NGROK_PORT_APP" `
        -PassThru -WindowStyle Minimized
    Start-Sleep -Seconds 2

    # Verifikasi server benar-benar jalan
    try {
        $check = Invoke-WebRequest -Uri "http://localhost:$NGROK_PORT_APP" -TimeoutSec 5 -UseBasicParsing -ErrorAction Stop
        OK "PHP server berjalan di http://localhost:$NGROK_PORT_APP (PID: $($phpServerProc.Id))"
    } catch {
        Warn "Server mungkin belum siap, lanjut..."
    }
    $localUrl    = "http://localhost:$NGROK_PORT_APP"
    $ngrokTarget = $NGROK_PORT_APP
}

# -----------------------------------------------------------
# LANGKAH 7 — Jalankan Ngrok
# -----------------------------------------------------------
$ngrokUrl = ""
if ($useNgrok) {
    Step "Menghentikan ngrok lama (jika masih jalan)..."
    Get-Process -Name "ngrok" -ErrorAction SilentlyContinue | Stop-Process -Force -ErrorAction SilentlyContinue
    Start-Sleep -Seconds 1

    Step "Memulai Ngrok → port $ngrokTarget ..."
    $ngrokProc = Start-Process `
        -FilePath  $ngrokPath `
        -ArgumentList "http", $ngrokTarget `
        -PassThru -WindowStyle Minimized
    OK "Ngrok dijalankan (PID: $($ngrokProc.Id))"
    Info "Menunggu $WAIT_NGROK detik agar ngrok siap..."
    Start-Sleep -Seconds $WAIT_NGROK

    # Ambil URL ngrok dari API lokal (port 4040)
    Step "Membaca URL ngrok..."
    $retries = 3
    for ($i = 1; $i -le $retries; $i++) {
        try {
            $apiData  = Invoke-RestMethod -Uri "http://localhost:4040/api/tunnels" -TimeoutSec 5
            # Ambil URL HTTPS pertama yang ditemukan
            $httpsUrl = $apiData.tunnels | Where-Object { $_.proto -eq "https" } | Select-Object -ExpandProperty public_url -First 1
            if (-not $httpsUrl) { $httpsUrl = $apiData.tunnels[0].public_url }
            if ($httpsUrl) { $ngrokUrl = $httpsUrl; break }
        } catch {
            if ($i -lt $retries) {
                Warn "Percobaan $i gagal, coba lagi..."
                Start-Sleep -Seconds 2
            }
        }
    }

    if ($ngrokUrl) {
        OK "URL Ngrok berhasil didapat: $ngrokUrl"

        # ── Update APP_URL & ASSET_URL di .env ─────────────────────────────
        $envContent = Get-Content $ENV_FILE -Raw -Encoding UTF8
        
        # Update atau tambah APP_URL & ASSET_URL
        if ($envContent -match "(?m)^APP_URL=") {
            $envContent = $envContent -replace "(?m)^APP_URL=.*", "APP_URL=$ngrokUrl"
        } else {
            $envContent += "`nAPP_URL=$ngrokUrl"
        }

        if ($envContent -match "(?m)^ASSET_URL=") {
            $envContent = $envContent -replace "(?m)^ASSET_URL=.*", "ASSET_URL=$ngrokUrl"
        } else {
            $envContent += "`nASSET_URL=$ngrokUrl"
        }

        $envContent | Set-Content $ENV_FILE -Encoding UTF8
        OK ".env diperbarui (APP_URL & ASSET_URL) dengan $ngrokUrl"

        # PENTING: Bersihkan config cache agar PHP baca .env terbaru
        Step "Refreshing Laravel Config..."
        & $phpPath artisan config:clear 2>&1 | Out-Null
        OK "Konfigurasi diperbarui dengan APP_URL baru"

    } else {
        Warn "Tidak bisa membaca URL ngrok secara otomatis."
        Warn "Buka manual di browser: http://localhost:4040"
    }
}

# -----------------------------------------------------------
# LANGKAH 8 — Tampilkan Ringkasan
# -----------------------------------------------------------
Write-Host ""
Write-Host "  +----------------------------------------------------------+" -ForegroundColor Green
Write-Host "  |   DONE: PROJECT SIAP DIAKSES!                            |" -ForegroundColor Green
Write-Host "  +----------------------------------------------------------+" -ForegroundColor Green

if ($ngrokUrl) {
    Write-Host "  |  NGROK (PUBLIK)  : $ngrokUrl" -ForegroundColor Magenta
    Write-Host "  |  Dashboard Ngrok : http://localhost:4040" -ForegroundColor Cyan
}
Write-Host "  |  Lokal           : $localUrl" -ForegroundColor White
Write-Host "  |" -ForegroundColor Green
Write-Host "  |  Project   : $PROJECT_PATH" -ForegroundColor DarkGray
Write-Host "  |  Database  : boto_delphi @ 127.0.0.1:3306" -ForegroundColor DarkGray
Write-Host "  |  PHP       : $phpPath" -ForegroundColor DarkGray
Write-Host "  +----------------------------------------------------------+" -ForegroundColor Green
Write-Host ""
Write-Host "  [TIP] Tekan CTRL+C untuk menghentikan (server tetap jalan di background)" -ForegroundColor DarkYellow
Write-Host ""

# -----------------------------------------------------------
# LANGKAH 9 — Buka browser otomatis
# -----------------------------------------------------------
Start-Sleep -Seconds 1
$urlToOpen = if ($ngrokUrl) { $ngrokUrl } else { $localUrl }
if ($urlToOpen) {
    Step "Membuka browser: $urlToOpen"
    Start-Process $urlToOpen
}

# Jaga window tetap terbuka
Read-Host "`n  Tekan Enter untuk keluar (proses server tetap berjalan di background)"
