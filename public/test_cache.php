<?php

// Temporary Cache Diagnostics Script
define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

header('Content-Type: application/json');

try {
    $defaultDriver = config('cache.default');
    
    // Attempt cache write
    \Illuminate\Support\Facades\Cache::put('diag_test_key', 'success_value', 10);
    
    // Attempt cache read
    $readValue = \Illuminate\Support\Facades\Cache::get('diag_test_key');
    
    // Directory permissions checks
    $storagePath = storage_path();
    $cachePath = storage_path('framework/cache');
    $cacheDataPath = storage_path('framework/cache/data');
    
    $permissions = [
        'storage' => [
            'exists' => file_exists($storagePath),
            'writable' => is_writable($storagePath),
            'perms' => substr(sprintf('%o', fileperms($storagePath)), -4)
        ],
        'framework_cache' => [
            'exists' => file_exists($cachePath),
            'writable' => is_writable($cachePath),
            'perms' => file_exists($cachePath) ? substr(sprintf('%o', fileperms($cachePath)), -4) : 'N/A'
        ],
        'framework_cache_data' => [
            'exists' => file_exists($cacheDataPath),
            'writable' => is_writable($cacheDataPath),
            'perms' => file_exists($cacheDataPath) ? substr(sprintf('%o', fileperms($cacheDataPath)), -4) : 'N/A'
        ]
    ];
    
    echo json_encode([
        'success' => true,
        'default_cache_driver' => $defaultDriver,
        'cache_write_read_test' => [
            'expected' => 'success_value',
            'actual' => $readValue,
            'status' => ($readValue === 'success_value') ? 'OK' : 'FAILED'
        ],
        'permissions' => $permissions
    ], JSON_PRETTY_PRINT);
    
} catch (\Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ], JSON_PRETTY_PRINT);
}

// Automatically clean up this file
@unlink(__FILE__);
