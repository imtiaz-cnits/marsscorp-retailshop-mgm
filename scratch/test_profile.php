<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$controller = new App\Http\Controllers\CustomerController();
$request = new Illuminate\Http\Request();

echo "--- Customer 75 (test 1) ---\n";
$res75 = $controller->CustomerProfileData($request, 75);
$data75 = $res75->getData();
echo "Summary: " . json_encode($data75->summary, JSON_PRETTY_PRINT) . "\n";
echo "Invoices:\n";
foreach ($data75->invoices as $inv) {
    echo "  Order ID: {$inv->id} | Order No: {$inv->order_no} | SubTotal: {$inv->sub_total} | Paid: {$inv->paid_amount} | Due: {$inv->due_amount} | RetAdj: {$inv->return_adjustment_amount} | Status: {$inv->payment_status}\n";
}
echo "Returns:\n";
foreach ($data75->returns as $ret) {
    echo "  Return ID: {$ret->id} | Order No: {$ret->order_no} | Product: {$ret->product_name} | Qty: {$ret->quantity} | Amount: {$ret->amount}\n";
}

echo "\n--- Customer 57 (Sobuj Vai) ---\n";
$res57 = $controller->CustomerProfileData($request, 57);
$data57 = $res57->getData();
echo "Summary: " . json_encode($data57->summary, JSON_PRETTY_PRINT) . "\n";
echo "Invoices:\n";
foreach ($data57->invoices as $inv) {
    echo "  Order ID: {$inv->id} | Order No: {$inv->order_no} | SubTotal: {$inv->sub_total} | Paid: {$inv->paid_amount} | Due: {$inv->due_amount} | RetAdj: {$inv->return_adjustment_amount} | Status: {$inv->payment_status}\n";
}
