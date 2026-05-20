<?php
$html = file_get_contents('scratch/sheet_html.html');
if (!$html) {
    $url = "https://docs.google.com/spreadsheets/d/1e3UZu0mxKD8Da8WIEQkX8JXAm7Z7TKDAUJBlXIeQsb0/edit?usp=sharing";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    $html = curl_exec($ch);
    file_put_contents('scratch/sheet_html.html', $html);
}

// Find all matches for sheet tab information
// Sheet info is usually in: bootstrapData = ...
preg_match('/bootstrapData\s*=\s*(.*?);<\/script>/s', $html, $matches);
if (isset($matches[1])) {
    echo "Found bootstrapData!\n";
    file_put_contents('scratch/bootstrap_data.json', $matches[1]);
    // Let's search for sheet name
    preg_match_all('/"name"\s*:\s*"([^"]+)"/', $matches[1], $names);
    print_r($names[1]);
} else {
    echo "bootstrapData not found. Searching for sheet names in raw text...\n";
    // General regex for sheet names
    preg_match_all('/"sheetName"\s*:\s*"([^"]+)"/', $html, $names);
    print_r(array_unique($names[1] ?? []));
}
