<?php
$json = file_get_contents('scratch/bootstrap_data.json');
echo "JSON length: " . strlen($json) . "\n";
// Let's do regex search for GID or sheet names
preg_match_all('/"([^"]+)":\s*"([^"]+)"/', $json, $matches, PREG_SET_ORDER);
$found = [];
foreach ($matches as $m) {
    if (stripos($m[1], 'title') !== false || stripos($m[1], 'sheet') !== false || stripos($m[1], 'name') !== false) {
        $found[] = $m[1] . " => " . $m[2];
    }
}
echo "Found matches:\n";
print_r(array_unique(array_slice($found, 0, 50)));

// Let's check if we can find any grid/sheet names
preg_match_all('/"title"\s*:\s*"([^"]+)"/', $json, $titles);
print_r(array_unique($titles[1] ?? []));

preg_match_all('/"sheetId"\s*:\s*(\d+)/', $json, $sheetIds);
print_r(array_unique($sheetIds[1] ?? []));
