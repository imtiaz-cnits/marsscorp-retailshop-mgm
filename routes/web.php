<?php

use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\ProductReturnController;
use App\Http\Controllers\OpeningBalanceController;


// User Registration API Route Strat
Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/admin-login-page', [UserController::class, 'UserLogin']);
Route::post('/nexus-login-page', [UserController::class, 'UserLogin']);
Route::post('/verify-otp', [UserController::class, 'VerifyOtp']);



// Route::post('/resend-otp', function (Request $request) {
//     $user = \App\Models\User::where('email', $request->email)->first();

//     if (!$user) {
//         return response()->json(['status' => 'failed', 'message' => 'User not found']);
//     }

//     $otp = rand(100000, 999999);
//     $user->otp = $otp;
//     $user->otp_expires_at = \Carbon\Carbon::now()->addMinutes(5);
//     $user->save();

//     \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OtpMail($otp));

//     return response()->json(['status' => 'otp_sent', 'message' => 'OTP resent to your email']);
// });


// User Registration API Route End

// Front-end View Route Api Start
Route::view('/', 'frontend.auth.registration-form');
Route::view('/admin-login-page', 'frontend.auth.registration-form');
Route::redirect('/nexus-login-page', '/admin-login-page');
Route::view('/user-verify-otp', 'frontend.otp.user-login-otp');
Route::get('/user-profile', [UserController::class, 'UsersProfile'])->middleware('auth:sanctum');
Route::post('/user-update', [UserController::class, 'UpdateProfile'])->middleware('auth:sanctum');



Route::get('/naxus-pos-logout', [UserController::class, 'UserLogout'])->middleware('auth:sanctum');

// Front-end View Route Api End


// Dashboard View Page Route Start
Route::view('/admin-dashboard-invoice', 'pages.back-end-page.invoice-view-page');
Route::view('/admin-dashboard-brand', 'pages.back-end-page.brand-page');
Route::view('/admin-dashboard-category', 'pages.back-end-page.category-page');
Route::view('/admin-dashboard-sub-category', 'pages.back-end-page.sub-category-page');
Route::view('/admin-dashboard-unit', 'pages.back-end-page.unit-page');
Route::view('/admin-dashboard-supplier', 'pages.back-end-page.supplier-page');
Route::view('/supplier-due-collection-page', 'pages.back-end-page.supplier-due-collection-page');
Route::view('/supplier-due-page', 'pages.back-end-page.supplier-due-page');
Route::view('/admin-dashboard-Purchase', 'pages.back-end-page.purchase-page');
Route::view('/admin-dashboard-product', 'pages.back-end-page.product-page');
Route::view('/admin-dashboard-barcode-genarate', 'backend.barcode-genarate.barcode-print');
Route::view('/admin-dashboard-product-barcode', 'backend.product-barcode-print.barcode-print');
Route::view('/admin-dashboard-warehouse', 'pages.back-end-page.warehouse-page');
Route::view('/admin-dashboard-pos', 'backend.pos.pos-page');
Route::view('/admin-dashboard-customer-invoice-report', 'pages.back-end-page.customer-invoice-report');



Route::view('/admin-dashboard', 'backend.admindashboard');
Route::view('/customer-page', 'pages.back-end-page.modal-page');
Route::view('/customer-due-collection-page', 'pages.back-end-page.customer-due-collection-page');
Route::view('/admin-dashboard-customer-due-list', 'pages.back-end-page.customer-due-page');


Route::view('/admin-dashboard-dsistrict', 'pages.back-end-page.district-page');
Route::view('/admin-dashboard-upazila', 'pages.back-end-page.upazila-page');
Route::view('/admin-dashboard-thana', 'pages.back-end-page.thana-page');
Route::view('/admin-dashboard-location', 'pages.back-end-page.location-page');
Route::view('/admin-dashboard-customer', 'pages.back-end-page.customer-page');
Route::view('/admin-dashboard-opening-balance', 'pages.back-end-page.opening-balance-page');


Route::get('/admin-dashboard-low-stock-notifications', [App\Http\Controllers\DashboardController::class, 'GetLowStockNotifications']);

// Role & User Management Routes
Route::view('/admin-dashboard-user-role', 'pages.back-end-page.user-role-page');
Route::get('/get-all-users', [UserController::class, 'GetAllUsers']);
Route::post('/create-user-admin', [UserController::class, 'CreateUserByAdmin']);
Route::post('/update-user-role-status', [UserController::class, 'UpdateUserRoleStatus']);
Route::post('/delete-user-admin', [UserController::class, 'DeleteUserByAdmin']);

// Dashboard View Route End



// report managment view page start

Route::view('/admin-dashboard-due-invoice', 'backend.report-management.invoice-due-report');
Route::view('/admin-dashboard-stock-out', 'backend.report-management.stock-out-report');

// report managment view page end


// invoice print start

Route::view('/invoice-print', 'backend.invoice.invoice-print');
Route::view('/due-invoice-print/{id}', 'backend.view-invoice.due-invoice-print');


Route::prefix('invoice')->group(function () {

    // Invoice Detail Page (By ID)
    Route::get('/{id}', [InvoiceController::class, 'InvoiceShowDetails'])->name('invoice.show');

    // API Routes for fetching data
    Route::post('/invoice-payment-details-by-id', [InvoiceController::class, 'getInvoiceDetailsById'])->name('invoice.details');
});


Route::prefix('purchase-invoice')->group(function () {

    // purchase Detail Page (By ID)
    Route::get('/{id}', [PurchasesController::class, 'PurchaseShowDetails'])->name('order.show');

    // API Routes for fetching data
    Route::post('/purchase-details-by-id', [PurchasesController::class, 'PurchaseDetailsById'])->name('order.details');
});

Route::prefix('return')->group(function () {

    // Return Detail Page (By ID)
    Route::get('/{id}', [ProductReturnController::class, 'ReturnShowDetails'])->name('return.show');

    // API Routes for fetching data
    Route::post('/return-details-by-id', [ProductReturnController::class, 'ReturnDetailsById'])->name('return.details');
});


Route::prefix('purchase-return')->group(function () {

    // Return Detail Page (By ID)
    Route::get('/{id}', [ProductReturnController::class, 'PurchaseReturnShowDetails'])->name('purchase-return.show');

    // API Routes for fetching data
    Route::post('/purchase-return-details-by-id', [ProductReturnController::class, 'PurchaseReturnDetailsById'])->name('purchase-return.details');
});



// Expence View Page Route Start

Route::view('/admin-dashboard-expence-type', 'pages.back-end-page.expense-type-page');
Route::view('/admin-dashboard-expence-list', 'pages.back-end-page.expense-list-page');
Route::view('/admin-dashboard-staff-profile', 'pages.back-end-page.staff-profile-page');

// Expence View Page Route End

Route::view('/admin-dashboard-investor-info', 'pages.back-end-page.investor-info-page');
Route::view('/admin-dashboard-invest-list', 'pages.back-end-page.investor-info-list-page');



// Invesment Managment View Page Start End



// Report Management View Page Start

Route::view('/admin-dashboard-sales-report', 'backend.report-management.sales-report');
Route::view('/admin-dashboard-income-expense-report', 'backend.report-management.income-expense-report');
Route::view('/admin-dashboard-daily-receipt-payment-report', 'backend.report-management.daily-receipt-payment-report');
Route::view('/admin-dashboard-personal-transaction-report', 'backend.report-management.personal-transaction-report');
Route::view('/admin-best-selling-report', 'backend.report-management.best-selling-report');
Route::view('/admin-dashboard-daily-ledger-report', 'backend.report-management.daily-ledger-report');


// Report Management View Page End


// Return Managment View Page Start
Route::view('/admin-dashboard-return-list', 'pages.back-end-page.return-page');

// Return Managment View Page End


Route::view('/admin-dashboard-user-profile', 'backend.user-profile.user-profile-page');

// কাস্টমার প্রোফাইল পেজ দেখানোর জন্য
Route::get('/customer/profile/{id}', [App\Http\Controllers\CustomerController::class, 'CustomerProfilePage']);

// সাপ্লাইয়ার প্রোফাইল পেজ দেখানোর জন্য
Route::get('/supplier/profile/{id}', [App\Http\Controllers\SupplierController::class, 'SupplierProfilePage']);




