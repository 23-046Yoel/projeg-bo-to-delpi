<?php
$passwords = ['', 'root', 'password', 'root123'];
$host = '127.0.0.1';
$user = 'root';

foreach ($passwords as $pass) {
    try {
        $pdo = new PDO("mysql:host=$host", $user, $pass);
        echo "SUCCESS_PASSWORD:|$pass|\n";
        exit(0);
    } catch (PDOException $e) {
        // Continue
    }
}
echo "FAILED_ALL\n";
exit(1);
