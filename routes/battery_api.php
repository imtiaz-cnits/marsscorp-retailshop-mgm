<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Battery\BatteryBrandController;
use App\Http\Controllers\Battery\BatteryCategoryController;
use App\Http\Controllers\Battery\BatterySubCategoryController;
use App\Http\Controllers\Battery\BatteryUnitController;
use App\Http\Controllers\Battery\BatteryProductController;
use App\Http\Controllers\Battery\BatterySupplierController;
use App\Http\Controllers\Battery\BatteryPurchaseController;
use App\Http\Controllers\Battery\BatterySupplierDueCollectionController;
use App\Http\Controllers\Battery\BatteryOrderController;
use App\Http\Controllers\Battery\BatteryInvoiceController;
use App\Http\Controllers\Battery\BatteryCustomerController;
use App\Http\Controllers\Battery\BatteryCustomerDueCollectionController;
use App\Http\Controllers\Battery\BatteryExpenseTypeController;
use App\Http\Controllers\Battery\BatteryExpenseController;
use App\Http\Controllers\Battery\BatteryProductReturnController;
use App\Http\Controllers\Battery\BatteryPurchaseReturnController;
use App\Http\Controllers\Battery\BatteryOpeningBalanceController;
use App\Http\Controllers\Battery\BatteryDashboardController;
use App\Http\Controllers\Battery\BatteryReportController;

/*
|--------------------------------------------------------------------------
| Battery Module API Routes
|--------------------------------------------------------------------------
|
| Included into routes/api.php under the 'battery' prefix. All endpoints
| resolve to /api/battery/... and require 'auth:sanctum' authentication.
|
*/

Route::prefix('battery')->middleware('auth:sanctum')->name('battery.api.')->group(function () {

    // Brands
    Route::get('/brand-list', [BatteryBrandController::class, 'BrandList'])->name('brand.list');
    Route::post('/create-brand', [BatteryBrandController::class, 'BrandCreate'])->name('brand.create');
    Route::post('/brand-by-id', [BatteryBrandController::class, 'BrandById'])->name('brand.by-id');
    Route::post('/update-brand', [BatteryBrandController::class, 'BrandUpdate'])->name('brand.update');
    Route::post('/delete-brand', [BatteryBrandController::class, 'BrandDelete'])->name('brand.delete');

    // Categories
    Route::get('/category-list', [BatteryCategoryController::class, 'CategoryList'])->name('category.list');
    Route::post('/create-category', [BatteryCategoryController::class, 'CategoryCreate'])->name('category.create');
    Route::post('/category-by-id', [BatteryCategoryController::class, 'CategoryByID'])->name('category.by-id');
    Route::post('/update-category', [BatteryCategoryController::class, 'CategoryUpdate'])->name('category.update');
    Route::post('/delete-category', [BatteryCategoryController::class, 'CategoryDelete'])->name('category.delete');

    // Sub Categories
    Route::get('/sub-category-list/{categoryId}', [BatterySubCategoryController::class, 'getSubCategoriesByCategory'])->name('sub-category.by-category');
    Route::get('/sub-category-list', [BatterySubCategoryController::class, 'SubCategoryList'])->name('sub-category.list');
    Route::post('/sub-create-category', [BatterySubCategoryController::class, 'SubCategoryCreate'])->name('sub-category.create');
    Route::post('/sub-category-by-id', [BatterySubCategoryController::class, 'SubCategoryByID'])->name('sub-category.by-id');
    Route::post('/update-sub-category', [BatterySubCategoryController::class, 'SubCategoryUpdate'])->name('sub-category.update');
    Route::post('/delete-sub-category', [BatterySubCategoryController::class, 'SubCategoryDelete'])->name('sub-category.delete');

    // Units
    Route::get('/unit-list', [BatteryUnitController::class, 'UnitList'])->name('unit.list');

    // Products & Stock
    Route::get('/product-search', [BatteryProductController::class, 'ProductIDSearch'])->name('product.search');
    Route::match(['get', 'post'], '/product-search-by-name', [BatteryProductController::class, 'ProductSearchByName'])->name('product.search-by-name');
    Route::get('/product-list', [BatteryProductController::class, 'ProductList'])->name('product.list');
    Route::post('/create-product', [BatteryProductController::class, 'ProductCreate'])->name('product.create');
    Route::post('/check-duplicate-product', [BatteryProductController::class, 'checkDuplicateProduct'])->name('product.check-duplicate');
    Route::post('/product-by-id', [BatteryProductController::class, 'ProductByID'])->name('product.by-id');
    Route::post('/update-product', [BatteryProductController::class, 'ProductUpdate'])->name('product.update');
    Route::post('/delete-product', [BatteryProductController::class, 'ProductDelete'])->name('product.delete');
    Route::get('/stock-out-product-list', [BatteryProductController::class, 'ProductStockOut'])->name('product.stock-out');

    // Suppliers & Supplier Dues
    Route::get('/supplier-list', [BatterySupplierController::class, 'SupplierList'])->name('supplier.list');
    Route::get('/supplier-due-list', [BatterySupplierController::class, 'SupplierDueList'])->name('supplier.due-list');
    Route::post('/create-supplier', [BatterySupplierController::class, 'SupplierCreate'])->name('supplier.create');
    Route::post('/supplier-by-id', [BatterySupplierController::class, 'SupplierByID'])->name('supplier.by-id');
    Route::post('/update-supplier', [BatterySupplierController::class, 'SupplierUpdate'])->name('supplier.update');
    Route::post('/delete-supplier', [BatterySupplierController::class, 'SupplierDelete'])->name('supplier.delete');

    // Supplier Due Collections
    Route::get('/supplier-due-collection-list', [BatterySupplierDueCollectionController::class, 'SupplierDueCollectionList'])->name('supplier-due.list');
    Route::post('/supplier-due-collection-details-by-id', [BatterySupplierDueCollectionController::class, 'SupplierDueCollectionByID'])->name('supplier-due.by-id');
    Route::post('/supplier-payment-details-update', [BatterySupplierDueCollectionController::class, 'SupplierPaymentDetailsUpdate'])->name('supplier-due.update');

    // Purchases & Purchase Payments
    Route::get('/purchases-list', [BatteryPurchaseController::class, 'PurchasesList'])->name('purchase.list');
    Route::post('/create-purchases', [BatteryPurchaseController::class, 'PurchasesCreate'])->name('purchase.create');
    Route::post('/purchases-by-id', [BatteryPurchaseController::class, 'PurchasesByID'])->name('purchase.by-id');
    Route::post('/update-purchases', [BatteryPurchaseController::class, 'PurchasesUpdate'])->name('purchase.update');
    Route::post('/delete-purchases', [BatteryPurchaseController::class, 'PurchasesDelete'])->name('purchase.delete');
    Route::post('/purchase-payment-details-by-id', [BatteryPurchaseController::class, 'getPaymentDetailsById'])->name('purchase.payment-details-by-id');
    Route::post('/update-purchase-payment', [BatteryPurchaseController::class, 'updatePaymentDetails'])->name('purchase.update-payment');

    // POS & Orders
    Route::post('/create-order', [BatteryOrderController::class, 'OrderCreate'])->name('order.create');

    // Invoices
    Route::get('/invoice-order-payment-details', [BatteryInvoiceController::class, 'InvoiceOrderPaymentDetails'])->name('invoice.payment-details');
    Route::post('/invoice-payment-details-by-id', [BatteryInvoiceController::class, 'InvoicePaymentDetailsByID'])->name('invoice.payment-details-by-id');
    Route::post('/invoice-payment-details-update', [BatteryInvoiceController::class, 'InvoicePaymentDetailsUpdate'])->name('invoice.payment-details-update');
    Route::post('/invoice-full-details-by-id', [BatteryInvoiceController::class, 'getInvoiceFullDetailsById'])->name('invoice.full-details-by-id');
    Route::post('/update-invoice-details', [BatteryInvoiceController::class, 'updateInvoiceDetails'])->name('invoice.update-details');
    Route::get('/invoice-order-due-details', [BatteryInvoiceController::class, 'InvoiceOrderDuePaymentDetails'])->name('invoice.due-details');

    // Customers & Customer Profile
    Route::get('/customer-list', [BatteryCustomerController::class, 'CustomerList'])->name('customer.list');
    Route::get('/customer-due-list', [BatteryCustomerController::class, 'CustomerDueList'])->name('customer.due-list');
    Route::post('/create-customer', [BatteryCustomerController::class, 'CustomerCreate'])->name('customer.create');
    Route::post('/customer-by-id', [BatteryCustomerController::class, 'CustomerByID'])->name('customer.by-id');
    Route::post('/update-customer', [BatteryCustomerController::class, 'CustomerUpdate'])->name('customer.update');
    Route::post('/delete-customer', [BatteryCustomerController::class, 'CustomerDelete'])->name('customer.delete');
    Route::get('/customer-profile-data/{id}', [BatteryCustomerController::class, 'CustomerProfileData'])->name('customer.profile-data');

    // Customer Due Collections (FIFO)
    Route::get('/customer-due-collection-list', [BatteryCustomerDueCollectionController::class, 'CustomerDueCollectionList'])->name('customer-due.list');
    Route::post('/customer-due-collection-details-by-id', [BatteryCustomerDueCollectionController::class, 'CustomerDueCollectionByID'])->name('customer-due.by-id');
    Route::post('/customer-payment-details-update', [BatteryCustomerDueCollectionController::class, 'CustomerPaymentDetailsUpdate'])->name('customer-due.update');
    Route::post('/customer-due-collection', [BatteryCustomerDueCollectionController::class, 'CustomerPaymentDetailsUpdate'])->name('customer-due.collection');

    // Expenses & Expense Types
    Route::get('/expense-type-list', [BatteryExpenseTypeController::class, 'ExpenseTypeList'])->name('expense-type.list');
    Route::post('/create-expense-type', [BatteryExpenseTypeController::class, 'ExpenseTypeCreate'])->name('expense-type.create');
    Route::post('/expense-type-by-id', [BatteryExpenseTypeController::class, 'ExpenseTypeByID'])->name('expense-type.by-id');
    Route::post('/update-expense-type', [BatteryExpenseTypeController::class, 'ExpenseTypeUpdate'])->name('expense-type.update');
    Route::post('/delete-expense-type', [BatteryExpenseTypeController::class, 'ExpenseTypeDelete'])->name('expense-type.delete');

    Route::get('/expense-list', [BatteryExpenseController::class, 'ExpenseList'])->name('expense.list');
    Route::post('/create-expense', [BatteryExpenseController::class, 'ExpenseCreate'])->name('expense.create');
    Route::post('/expense-by-id', [BatteryExpenseController::class, 'ExpenseByID'])->name('expense.by-id');
    Route::post('/update-expense', [BatteryExpenseController::class, 'ExpenseUpdate'])->name('expense.update');
    Route::post('/delete-expense', [BatteryExpenseController::class, 'ExpenseDelete'])->name('expense.delete');

    // Returns (Sales Return & Purchase Return)
    Route::get('/return-product-list', [BatteryProductReturnController::class, 'ReturnProductList'])->name('return.list');
    Route::post('/create-return-product', [BatteryProductReturnController::class, 'ReturnProductCreate'])->name('return.create');
    Route::get('/search-invoice-for-return', [BatteryProductReturnController::class, 'SearchInvoiceForReturn'])->name('return.search-invoice');

    Route::get('/purchase-return-list', [BatteryPurchaseReturnController::class, 'PurchaseReturnList'])->name('purchase-return.list');
    Route::get('/search-purchase-for-return', [BatteryPurchaseReturnController::class, 'SearchPurchaseForReturn'])->name('purchase-return.search');
    Route::post('/create-purchase-return', [BatteryPurchaseReturnController::class, 'PurchaseReturnProductCreate'])->name('purchase-return.create');

    // Opening Balance
    Route::get('/opening-balance-list', [BatteryOpeningBalanceController::class, 'OpeningBalanceList'])->name('opening-balance.list');
    Route::post('/create-opening-balance', [BatteryOpeningBalanceController::class, 'OpeningBalanceCreate'])->name('opening-balance.create');
    Route::post('/opening-balance-by-id', [BatteryOpeningBalanceController::class, 'OpeningBalanceById'])->name('opening-balance.by-id');
    Route::post('/update-opening-balance', [BatteryOpeningBalanceController::class, 'OpeningBalanceUpdate'])->name('opening-balance.update');
    Route::post('/delete-opening-balance', [BatteryOpeningBalanceController::class, 'OpeningBalanceDelete'])->name('opening-balance.delete');

    // Dashboard & Reports Analytics
    Route::get('/dashboard-all-calculation', [BatteryDashboardController::class, 'DashboardAllCalculation'])->name('dashboard.calculation');
    Route::get('/low-stock-notifications', [BatteryDashboardController::class, 'GetLowStockNotifications'])->name('dashboard.low-stock');
    Route::get('/sales-report-list', [BatteryReportController::class, 'SalesReportList'])->name('report.sales');
    Route::get('/daily-receipt-payment-report', [BatteryReportController::class, 'DailyReceiptPaymentReport'])->name('report.daily-receipt');
    Route::get('/income-expense-report-list', [BatteryReportController::class, 'AllSummeryReport'])->name('report.income-expense');
    Route::get('/daily-ledger-report-list', [BatteryReportController::class, 'DailyLedgerReportList'])->name('report.daily-ledger');

});
