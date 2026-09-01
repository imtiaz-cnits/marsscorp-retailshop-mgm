<?php

$viewsDir = 'c:/xampp/htdocs/riad-door-shop/resources/views';
$dir = new RecursiveDirectoryIterator($viewsDir);
$iterator = new RecursiveIteratorIterator($dir);
$count = 0;

$searchReplacements = [
    'মেসার্স আনিস ষ্টোর' => 'মার্স কর্পোরেশন (MARSS CORPORATION)',
    'আনিস ষ্টোর' => 'মার্স কর্পোরেশন',
    'Anis Store' => 'MARSS CORPORATION',
    'anis-store-logo.png' => 'marss-corporation-logo.svg',
    'anis-store-icon.png' => 'marss-corporation-icon.svg',
    '01792-833747' => '01975-703216',
    '01792833747' => '01975703216',
    'admin@anisstore.com' => 'admin@marsscorporation.com',
    'Anis Store Admin' => 'MARSS Corporation Admin',
];

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $filePath = $file->getPathname();
        $content = file_get_contents($filePath);
        $newContent = $content;

        foreach ($searchReplacements as $search => $replace) {
            $newContent = str_replace($search, $replace, $newContent);
        }

        if ($newContent !== $content) {
            file_put_contents($filePath, $newContent);
            echo "Rebranded file: " . $filePath . "\n";
            $count++;
        }
    }
}

echo "Total files updated and rebranded to MARSS CORPORATION: " . $count . "\n";
