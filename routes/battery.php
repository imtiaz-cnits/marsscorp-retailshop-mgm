<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Battery\BatteryCustomerController;
use App\Http\Controllers\Battery\BatterySupplierController;
use App\Http\Controllers\Battery\BatteryPurchaseController;
use App\Http\Controllers\Battery\BatteryInvoiceController;
use App\Http\Controllers\Battery\BatteryProductReturnController;
use App\Http\Controllers\Battery\BatteryPurchaseReturnController;

/*
|--------------------------------------------------------------------------
| Battery Module Web View Routes
|--------------------------------------------------------------------------
|
| All Battery web views are grouped under the '/battery' URL prefix and
| 'battery.' route name prefix. 100% isolated from Retail web routes.
|
*/

Route::prefix('battery')->name('battery.')->group(function () {

    // Dashboard
    Route::view('/dashboard', 'battery.dashboard.battery-dashboard')->name('dashboard');

    // POS & Sales
    Route::view('/pos', 'battery.pos.pos-page')->name('pos');
    Route::view('/invoices', 'battery.invoice.invoice-view-page')->name('invoices');
    Route::get('/invoice/{id}', [BatteryInvoiceController::class, 'InvoiceShowDetails'])->name('invoice.show');
    Route::get('/due-invoice-print/{id}', [BatteryInvoiceController::class, 'InvoiceShowDetails'])->name('invoice.due.print');

    // Catalog Management
    Route::view('/products', 'battery.product.product-page')->name('products');
    Route::view('/brands', 'battery.brand.brand-page')->name('brands');
    Route::view('/categories', 'battery.category.category-page')->name('categories');
    Route::view('/sub-categories', 'battery.category.sub-category-page')->name('sub-categories');
    Route::view('/units', 'battery.unit.unit-page')->name('units');
    Route::view('/barcode-generate', 'battery.barcode.barcode-print')->name('barcode.generate');

    // Supplier & Procurement
    Route::view('/suppliers', 'battery.supplier.supplier-page')->name('suppliers');
    Route::get('/supplier/profile/{id}', [BatterySupplierController::class, 'SupplierProfilePage'])->name('supplier.profile');
    Route::view('/purchases', 'battery.purchase.purchase-page')->name('purchases');
    Route::get('/purchase-invoice/{id}', [BatteryPurchaseController::class, 'PurchaseShowDetails'])->name('purchase.invoice.show');
    Route::view('/purchase-payments', 'battery.purchase.purchase-payment-page')->name('purchase.payments');
    Route::view('/supplier-due', 'battery.supplier.supplier-due-page')->name('supplier.due');
    Route::view('/supplier-due-collection', 'battery.supplier.supplier-due-collection-page')->name('supplier.due.collection');

    // Customer & Receivables
    Route::view('/customers', 'battery.customer.customer-page')->name('customers');
    Route::get('/customer/profile/{id}', [BatteryCustomerController::class, 'CustomerProfilePage'])->name('customer.profile');
    Route::view('/customer-due', 'battery.customer.customer-due-page')->name('customer.due');
    Route::view('/customer-due-collection', 'battery.customer.customer-due-collection-page')->name('customer.due.collection');

    // Operating Expenses
    Route::view('/expenses', 'battery.expense.expense-list-page')->name('expenses');
    Route::view('/expense-types', 'battery.expense.expense-type-page')->name('expense.types');

    // Returns
    Route::view('/sales-returns', 'battery.return.return-page')->name('sales.returns');
    Route::get('/return/{id}', [BatteryProductReturnController::class, 'ReturnShowDetails'])->name('return.show');
    Route::view('/purchase-returns', 'battery.return.purchase-return-page')->name('purchase.returns');
    Route::get('/purchase-return/{id}', [BatteryPurchaseReturnController::class, 'PurchaseReturnShowDetails'])->name('purchase-return.show');

    // Opening Balance
    Route::view('/opening-balance', 'battery.opening-balance.opening-balance-page')->name('opening.balance');

    // Reports Management
    Route::view('/reports/sales', 'battery.report.sales-report')->name('reports.sales');
    Route::view('/reports/daily-ledger', 'battery.report.daily-ledger-report')->name('reports.daily-ledger');
    Route::view('/reports/income-expense', 'battery.report.income-expense-report')->name('reports.income-expense');
    Route::view('/reports/daily-receipt-payment', 'battery.report.daily-receipt-payment-report')->name('reports.daily-receipt-payment');
    Route::view('/reports/stock-out', 'battery.report.stock-out-report')->name('reports.stock-out');

});
