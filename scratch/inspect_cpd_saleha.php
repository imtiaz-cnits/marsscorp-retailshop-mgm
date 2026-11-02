<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$cols = DB::getSchemaBuilder()->getColumnListing('customer_payment_details');
echo "CPD Columns: " . implode(', ', $cols) . "\n";

$cpds = DB::table('customer_payment_details')
    ->where('customer_id', 1)
    ->orderBy('id', 'asc')
    ->get();

$running = 409680.00;
echo "Opening previous_due_amount baseline: 409,680.00\n";
printf("%-4s | %-12s | %-19s | %-19s | %-10s | %-12s | %-12s\n", 
    "ID", "Pay Date", "Created At", "Updated At", "Paid Amt", "Current Due", "Running Math");
echo str_repeat("-", 105) . "\n";

foreach ($cpds as $c) {
    $paid = (float)($c->payment_amount ?? $c->paid_amount ?? 0);
    $running -= $paid;
    printf("%-4d | %-12s | %-19s | %-19s | %-10.2f | %-12.2f | %-12.2f\n",
        $c->id,
        $c->payment_date ?? $c->date ?? 'N/A',
        $c->created_at,
        $c->updated_at,
        $paid,
        (float)($c->current_due_amount ?? $c->due_amount ?? 0),
        $running
    );
}

echo "\n=== ALL COLUMNS OF CPD ROWS FOR CUSTOMER 1 ===\n";
foreach ($cpds as $c) {
    echo json_encode($c) . "\n";
}

