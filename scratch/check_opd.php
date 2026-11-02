<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== TABLE: order_payment_details ===\n";
$opds = DB::table('order_payment_details')->get();
echo "Count: " . $opds->count() . "\n";
foreach ($opds as $opd) {
    echo sprintf("ID: %-3d | OrderID: %-3d | Paid: %-8s | Disc: %-5s | Status: %-12s | Method: %-6s | Date: %s | Created: %s\n",
        $opd->id, $opd->order_id, $opd->paid_amount, $opd->discount_amount ?? 'NULL', $opd->payment_status, $opd->payment_method, $opd->due_collection_date, $opd->created_at);
}

