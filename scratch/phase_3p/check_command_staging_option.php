<?php
$content = file_get_contents('app/Console/Commands/MigrateRetailToBatteryCommand.php');
$lines = explode("\n", $content);
foreach ($lines as $num => $line) {
    if (stripos($line, 'staging') !== false || stripos($line, 'expected target') !== false || stripos($line, 'allow-staging') !== false) {
        echo "Line " . ($num + 1) . ": " . trim($line) . "\n";
    }
}

