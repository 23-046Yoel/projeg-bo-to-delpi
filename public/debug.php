<?php
/**
 * Debug Script to show real errors
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug BoTo Delphi</h1>";
echo "PHP Version: " . phpversion() . "<br>";

try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require __DIR__ . '/../bootstrap/app.php';
    echo "✅ Autoload & Bootstrap OK!<br>";
    
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    echo "✅ Laravel Kernel Bootstrapped!<br>";
    
    echo "✅ Database connection: ";
    try {
        DB::connection()->getPdo();
        echo "OK!<br>";
    } catch (\Exception $e) {
        echo "FAILED: " . $e->getMessage() . "<br>";
    }

} catch (\Throwable $e) {
    echo "<div style='color:red; background:#fee; padding:20px; border:1px solid red;'>";
    echo "<h3>🔴 ERROR DETECTED:</h3>";
    echo "<b>Message:</b> " . $e->getMessage() . "<br>";
    echo "<b>File:</b> " . $e->getFile() . " on line " . $e->getLine() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
}
