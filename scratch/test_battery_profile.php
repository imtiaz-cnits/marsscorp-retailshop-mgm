<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Battery\BatteryCustomer;
use App\Models\Battery\BatteryOrder;
use App\Models\Battery\BatteryProductReturn;
use App\Http\Controllers\Battery\BatteryCustomerController;
use App\Http\Controllers\Battery\BatteryInvoiceController;

echo "Total Battery Customers: " . BatteryCustomer::count() . "\n";
echo "Total Battery Orders: " . BatteryOrder::count() . "\n";
echo "Total Battery Returns: " . BatteryProductReturn::count() . "\n";

$firstCustomer = BatteryCustomer::first();
if ($firstCustomer) {
    echo "\nTesting first Battery Customer (ID: {$firstCustomer->id}, Name: {$firstCustomer->customer_name}):\n";
    $controller = new BatteryCustomerController();
    $res = $controller->CustomerProfileData($firstCustomer->id);
    $data = $res->getData();
    echo "Status: " . ($data->status ?? 'none') . "\n";
    if (isset($data->summary)) {
        echo "Summary: " . json_encode($data->summary, JSON_PRETTY_PRINT) . "\n";
    }
    if (!empty($data->invoices)) {
        foreach ($data->invoices as $inv) {
            echo "  Invoice {$inv->order_no} | SubTotal: {$inv->sub_total} | Paid: {$inv->paid_amount} | Due: {$inv->due_amount} | Status: {$inv->payment_status}\n";
        }
    } else {
        echo "  (No battery invoices yet)\n";
    }
}

$firstOrder = BatteryOrder::first();
if ($firstOrder) {
    echo "\nTesting Battery Invoice View (Order ID: {$firstOrder->id}):\n";
    $invController = new BatteryInvoiceController();
    $view = $invController->InvoiceShowDetails($firstOrder->id);
    $html = $view->render();
    echo "Battery Invoice View Rendered successfully! Length: " . strlen($html) . " bytes\n";
}
