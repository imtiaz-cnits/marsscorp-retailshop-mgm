<?php
$content = file_get_contents('app/Console/Commands/MigrateRetailToBatteryCommand.php');

echo "=== LOCK TABLES AUDIT IN COMMAND CODE ===\n";
if (stripos($content, 'LOCK TABLES') !== false) {
    echo "FOUND literal 'LOCK TABLES' in code!\n";
} else {
    echo "NO literal 'LOCK TABLES' found in MigrateRetailToBatteryCommand.php.\n";
}

if (stripos($content, 'lock') !== false) {
    echo "Found occurrences of word 'lock':\n";
    $lines = explode("\n", $content);
    foreach ($lines as $num => $line) {
        if (stripos($line, 'lock') !== false) {
            echo "  Line " . ($num + 1) . ": " . trim($line) . "\n";
        }
    }
} else {
    echo "NO occurrences of 'lock' found in code.\n";
}

// Check how transactions are handled
preg_match_all('/(?:DB::|beginTransaction|commit|rollBack)/', $content, $matches);
echo "\nTransaction keywords found in Command: " . count($matches[0]) . "\n";
$lines = explode("\n", $content);
foreach ($lines as $num => $line) {
    if (preg_match('/(?:beginTransaction|commit|rollBack)/', $line)) {
        echo "  Line " . ($num + 1) . ": " . trim($line) . "\n";
    }
}

