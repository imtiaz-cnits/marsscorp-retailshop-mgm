<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;

$user = User::first();
if (!$user) {
    die("No user found.\n");
}
Auth::login($user);
Sanctum::actingAs($user, ['*']);

$retailPages = [
    '/admin-dashboard',
    '/admin-dashboard-pos',
    '/admin-dashboard-invoice',
    '/admin-dashboard-product',
    '/admin-dashboard-brand',
    '/admin-dashboard-category',
    '/admin-dashboard-supplier',
    '/admin-dashboard-customer',
    '/admin-dashboard-Purchase',
    '/admin-dashboard-expence-type',
    '/admin-dashboard-expence-list',
    '/admin-dashboard-sales-report',
    '/admin-dashboard-income-expense-report',
    '/admin-dashboard-daily-receipt-payment-report',
];

$retailApis = [
    '/api/product-list',
    '/api/customer-list',
    '/api/supplier-list',
    '/api/brand-list',
    '/api/category-list',
    '/api/unit-list',
    '/api/expense-list',
    '/api/purchases-list',
    '/api/invoice-order-payment-details',
    '/api/dashboard-all-calculation',
];

echo "=====================================================\n";
echo "           RETAIL REGRESSION VERIFICATION\n";
echo "=====================================================\n\n";

$allPassed = true;

echo "--- Testing Retail Web Pages ---\n";
foreach ($retailPages as $uri) {
    $req = Request::create($uri, 'GET');
    $res = $app->handle($req);
    $status = $res->getStatusCode();
    $ok = ($status === 200);
    if (!$ok) $allPassed = false;
    $badge = $ok ? "[PASS]" : "[FAIL]";
    echo "{$badge} {$uri} -> Status {$status}\n";
}

echo "\n--- Testing Representative Retail APIs ---\n";
foreach ($retailApis as $uri) {
    $req = Request::create($uri, 'GET', [], [], [], [
        'HTTP_ACCEPT' => 'application/json',
    ]);
    $res = $app->handle($req);
    $status = $res->getStatusCode();
    $ok = ($status === 200);
    if (!$ok) $allPassed = false;
    $badge = $ok ? "[PASS]" : "[FAIL]";
    echo "{$badge} {$uri} -> Status {$status}\n";
}

echo "\n=====================================================\n";
if ($allPassed) {
    echo "RESULT: ALL RETAIL PAGES & APIS FUNCTIONAL (100% PASS)\n";
} else {
    echo "RESULT: FAILURES ENCOUNTERED IN RETAIL REGRESSION\n";
}
echo "=====================================================\n";

exit($allPassed ? 0 : 1);
