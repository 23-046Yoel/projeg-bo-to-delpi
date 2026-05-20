<?php
$url = "https://docs.google.com/spreadsheets/d/1e3UZu0mxKD8Da8WIEQkX8JXAm7Z7TKDAUJBlXIeQsb0/export?format=csv&gid=437285728";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
$data = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "HTTP Code: " . $info['http_code'] . "\n";
echo "Length: " . strlen($data) . "\n";

$lines = explode("\n", $data);
echo "Headers:\n" . $lines[0] . "\n\n";
echo "Row 1:\n" . $lines[1] . "\n\n";
echo "Row 2:\n" . $lines[2] . "\n\n";
echo "Row 3:\n" . $lines[3] . "\n\n";
echo "Row 4:\n" . $lines[4] . "\n\n";
file_put_contents('scratch/sheet_data.csv', $data);


