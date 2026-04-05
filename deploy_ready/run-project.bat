@echo off
setlocal
title [Laragon Terminal] Run Bo To Delpi + Ngrok

:: --- CONFIG ---
set "PROJECT_DIR=c:\laragon\www\projeg Bo To Delpi"
set "PS_SCRIPT=jalankan-dengan-ngrok.ps1"

echo ========================================================
echo    🚀  LARAGON TERMINAL RUNNER: Bo To Delpi
echo ========================================================

:: Masuk ke direktori project
cd /d "%PROJECT_DIR%"

:: Cek apakah file PowerShell ada
if not exist "%PS_SCRIPT%" (
    echo [ERROR] File %PS_SCRIPT% tidak ditemukan!
    pause
    exit /b 1
)

:: Jalankan via PowerShell dengan bypass policy
echo [INFO] Menjalankan script utama via PowerShell...
powershell -ExecutionPolicy Bypass -File "%PS_SCRIPT%"

echo.
echo ========================================================
echo    Dijalankan dari Terminal Laragon
echo ========================================================
pause
