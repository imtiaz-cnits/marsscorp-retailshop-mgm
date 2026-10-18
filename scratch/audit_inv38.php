<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\ProductReturn;

$o = Order::with('details.product', 'customer')->where('order_no', 'like', '%00038')->first();
if ($o) {
    echo "Order ID: {$o->id} | Order No: {$o->order_no} | SubTotal: {$o->sub_total} | Paid: {$o->paid_amount} | Due: {$o->due_amount} | RetAdj: {$o->return_adjustment_amount}\n";
    echo "Customer: " . ($o->customer->customer_name ?? 'N/A') . " (ID: {$o->customer_id})\n";
    echo "Total Details: " . $o->details->count() . "\n";
    foreach ($o->details as $d) {
        $pName = $d->product->product_name ?? 'N/A';
        echo "  Detail #{$d->id} | Product #{$d->product_id}: {$pName} | Qty: {$d->quantity} | RetQty: {$d->return_quantity} | Price: {$d->price} | SellingPrice: {$d->selling_price}\n";
    }
}

echo "\n--- Product Returns for this order ---\n";
$returns = ProductReturn::where('order_id', $o->id ?? 0)->get();
echo "Total returns: " . $returns->count() . "\n";
foreach ($returns as $r) {
    $p = App\Models\Product::find($r->product_id);
    echo "  Return #{$r->id} | Product: " . ($p->product_name ?? 'N/A') . " | Qty: {$r->quantity} | Amount: {$r->amount} | Date: {$r->date} | CreatedAt: {$r->created_at}\n";
}
