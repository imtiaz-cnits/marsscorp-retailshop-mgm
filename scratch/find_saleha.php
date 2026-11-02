<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$cols = DB::getSchemaBuilder()->getColumnListing('customers');
echo "Columns: " . implode(', ', $cols) . "\n";

$customers = DB::table('customers')->where('customer_name', 'LIKE', '%Saleha%')->orWhere('customer_name', 'LIKE', '%Ma%')->get();
foreach ($customers as $c) {
    echo "ID: {$c->id}, Name: {$c->customer_name}, PrevDue: {$c->previous_due_amount}, Created: {$c->created_at}, Updated: {$c->updated_at}\n";
}
