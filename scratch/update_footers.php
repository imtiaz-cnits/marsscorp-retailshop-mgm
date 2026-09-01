<?php

$dir = new RecursiveDirectoryIterator('c:/xampp/htdocs/anis-store/resources/views');
$iterator = new RecursiveIteratorIterator($dir);
$count = 0;

$replacement = '<footer class="footer text-center py-3 mt-4 text-muted small border-top">&copy; ' . date('Y') . ' মেসার্স আনিস ষ্টোর | Software By: <a href="https://www.codenextit.com" target="_blank" class="text-success fw-bold text-decoration-none">CodeNext IT</a></footer>';

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $filePath = $file->getPathname();
        $content = file_get_contents($filePath);
        
        $newContent = preg_replace('/<p>&copy;\s*\d{4}\.?\s*All Rights Reserved\.?<\/p>/i', $replacement, $content);
        
        if ($newContent !== $content) {
            file_put_contents($filePath, $newContent);
            echo "Updated: " . $filePath . "\n";
            $count++;
        }
    }
}

echo "Total files updated: " . $count . "\n";
