<?php
require 'vendor/autoload.php';

$apiKey = 'AIzaSyAjzGFCJVDifrLUQle5SW87KF6kwZd_5ow';

$candidates = [
    'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent',
    'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent',
    'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent',
    'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent',
    'https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent',
    'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent',
];

foreach ($candidates as $url) {
    echo "Testing URL: $url\n";
    $testUrl = $url . '?key=' . $apiKey;

    $data = [
        'contents' => [['parts' => [['text' => 'hi']]]]
    ];

    $ch = curl_init($testUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "Status: $status\n";
    if ($status === 200) {
        echo "SUCCESS! Working URL: $url\n";
        break;
    } else {
        echo "Response: $response\n";
    }
    echo "-------------------\n";
}
