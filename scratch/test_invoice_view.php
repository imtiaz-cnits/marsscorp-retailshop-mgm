<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$controller = new App\Http\Controllers\InvoiceController();
$view = $controller->InvoiceShowDetails(79);
$html = $view->render();

echo "Render successful for Order 79!\n";
if (strpos($html, 'Messio-B') !== false) {
    echo "Found product 'Messio-B' in invoice!\n";
} else {
    echo "MISSING product 'Messio-B'!\n";
}
if (strpos($html, 'Returned') !== false) {
    echo "Found 'Returned' badge in invoice!\n";
} else {
    echo "MISSING 'Returned' badge!\n";
}
if (strpos($html, '3,000.00') !== false) {
    echo "Found '3,000.00' total bill!\n";
} else {
    echo "MISSING '3,000.00'!\n";
}
if (strpos($html, 'Three Thousand Taka Only') !== false) {
    echo "Found 'Three Thousand Taka Only'!\n";
} else {
    echo "Check numberToWords or words.\n";
}
