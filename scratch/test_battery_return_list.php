<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$controller = new App\Http\Controllers\Battery\BatteryProductReturnController();
$response = $controller->ReturnProductList();
$data = json_decode($response->getContent(), true);

echo "Status: " . $data['status'] . "\n";
echo "Total Grouped Return Records: " . count($data['ProductReturnData']) . "\n\n";

foreach ($data['ProductReturnData'] as $idx => $row) {
    echo "Row " . ($idx + 1) . ":\n";
    echo "  Return Ref: " . $row['return_number'] . "\n";
    echo "  Invoice No: " . $row['order_no'] . "\n";
    echo "  Customer:   " . $row['customer_name'] . "\n";
    echo "  Product(s): " . $row['product_name'] . "\n";
    echo "  Items Count:" . $row['items_count'] . "\n";
    echo "  Total Qty:  " . $row['quantity'] . " " . $row['unit'] . "\n";
    echo "  Total Amt:  ৳" . number_format($row['amount'], 2) . "\n";
    echo "  Items:\n";
    foreach ($row['items'] as $item) {
        echo "    - " . $item['product_name'] . " | Qty: " . $item['quantity'] . " | Rate: ৳" . $item['unit_price'] . " | Line: ৳" . $item['amount'] . "\n";
    }
    echo "\n";
}
