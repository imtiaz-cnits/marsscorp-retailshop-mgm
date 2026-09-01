<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ThanaController;
use App\Http\Controllers\InvestController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UpazilasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\InvestorInfoController;
use App\Http\Controllers\ProductReturnController;
use App\Http\Controllers\ReportManagementController;
use App\Http\Controllers\CustomerDueCollectionController;
use App\Http\Controllers\SupplierDueCollectionController;
use App\Http\Controllers\OpeningBalanceController;
use App\Http\Controllers\UserController;

// Authentication API Routes
Route::post('/admin-login-page', [UserController::class, 'UserLogin']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/verify-otp', [UserController::class, 'VerifyOtp']);

// Dashboard All API Route Start

// Brand Api Route Start
Route::get("/brand-list", [BrandController::class, 'BrandList'])->middleware('auth:sanctum');
Route::post("/create-brand", [BrandController::class, 'BrandCreate'])->middleware('auth:sanctum');
Route::post("/brand-by-id", [BrandController::class, 'BrandById'])->middleware('auth:sanctum');
Route::post("/update-brand", [BrandController::class, 'BrandUpdate'])->middleware('auth:sanctum');
Route::post("/delete-brand", [BrandController::class, 'BrandDelete'])->middleware('auth:sanctum');
// Brand Api Route End

// Category Api Route Start


// Route::get("/product-category-data-show", [CategoryController::class, 'GetCategoriesList'])->middleware('auth:sanctum');
// Route::get("/category-wish-product-data-show", [CategoryController::class, 'CategoryWishProductDataShow'])->middleware('auth:sanctum');

Route::get("/product-brand-data-show", [CategoryController::class, 'GetBrandsList'])->middleware('auth:sanctum');
Route::get("/brand-wish-product-data-show", [CategoryController::class, 'BrandWishProductDataShow'])->middleware('auth:sanctum');



Route::get("/category-list", [CategoryController::class, 'CategoryList'])->middleware('auth:sanctum');
Route::post("/create-category", [CategoryController::class, 'CategoryCreate'])->middleware('auth:sanctum');
Route::post("/category-by-id", [CategoryController::class, 'CategoryByID'])->middleware('auth:sanctum');
Route::post("/update-category", [CategoryController::class, 'CategoryUpdate'])->middleware('auth:sanctum');
Route::post("delete-category", [CategoryController::class, 'CategoryDelete'])->middleware('auth:sanctum');

// Category Api Route End

// Product Sub Category Api Route Start
Route::get('/sub-category-list/{categoryId}', [SubCategoryController::class, 'getSubCategoriesByCategory'])->middleware('auth:sanctum');
Route::get("/sub-category-list", [SubCategoryController::class, 'SubCategoryList'])->middleware('auth:sanctum');
Route::post("/sub-create-category", [SubCategoryController::class, 'SubCategoryCreate'])->middleware('auth:sanctum');
Route::post("/sub-category-by-id", [SubCategoryController::class, 'SubCategoryByID'])->middleware('auth:sanctum');
Route::post("/update-sub-category", [SubCategoryController::class, 'SubCategoryUpdate'])->middleware('auth:sanctum');
Route::post("delete-sub-category", [SubCategoryController::class, 'SubCategoryDelete'])->middleware('auth:sanctum');

// Category Api Route End



//Product  Api Route Start

Route::get('/api/all-products-data-show', [ProductController::class, 'AllProductsDataShow']);

Route::get('/product-search', [ProductController::class, 'ProductIDSearch'])->middleware('auth:sanctum');

Route::get("/product-list", [ProductController::class, 'ProductList'])->middleware('auth:sanctum');
Route::post("/create-product", [ProductController::class, 'ProductCreate'])->middleware('auth:sanctum');
Route::post("/product-by-id", [ProductController::class, 'ProductByID'])->middleware('auth:sanctum');
Route::post("/update-product", [ProductController::class, 'ProductUpdate'])->middleware('auth:sanctum');
Route::post("/delete-product", [ProductController::class, 'ProductDelete'])->middleware('auth:sanctum');
Route::get("/unit-list", [ProductController::class, 'UnitList'])->middleware('auth:sanctum');

// Product Api Route End



//Supriler  Api Route Start
Route::get("/admin-dashboard-supplier-due-collection", [SupplierDueCollectionController::class, 'SupplierDueCollectionList'])->middleware('auth:sanctum');
Route::post("/supplier-due-collection-details-by-id", [SupplierDueCollectionController::class, 'SupplierDueCollectionByID'])->middleware('auth:sanctum');
Route::post("/supplier-payment-details-update", [SupplierDueCollectionController::class, 'SupplierPaymentDetailsUpdate'])->middleware('auth:sanctum');




Route::get("/supplier-list-report-due-amount", [SupplierController::class, 'SupplierPayableDueList'])->middleware('auth:sanctum');
Route::get("/supplier-list", [SupplierController::class, 'SupplierList'])->middleware('auth:sanctum');
Route::get("/supplier-due-list", [SupplierController::class, 'SupplierDueList'])->middleware('auth:sanctum');
Route::get("/supplier-profile-data/{id}", [SupplierController::class, 'SupplierProfileData'])->middleware('auth:sanctum');
Route::post("/create-supplier", [SupplierController::class, 'SupplierCreate'])->middleware('auth:sanctum');
Route::post("/supplier-by-id", [SupplierController::class, 'SupplierByID'])->middleware('auth:sanctum');
Route::post("/update-supplier", [SupplierController::class, 'SupplierUpdate'])->middleware('auth:sanctum');
Route::post("/delete-supplier", [SupplierController::class, 'SupplierDelete'])->middleware('auth:sanctum');

// Supriler Api Route End


// Purchases Api Route Start

Route::get("/purchases-list", [PurchasesController::class, 'PurchasesList'])->middleware('auth:sanctum');
Route::post("/create-purchases", [PurchasesController::class, 'PurchasesCreate'])->middleware('auth:sanctum');
Route::post("/purchases-by-id", [PurchasesController::class, 'PurchasesByID'])->middleware('auth:sanctum');
Route::post("/update-purchases", [PurchasesController::class, 'PurchasesUpdate'])->middleware('auth:sanctum');
Route::post("/delete-purchases", [PurchasesController::class, 'PurchasesDelete'])->middleware('auth:sanctum');


Route::post('/purchase-payment-details-by-id', [PurchasesController::class, 'getPaymentDetailsById'])->middleware('auth:sanctum');
Route::post('/update-purchase-payment', [PurchasesController::class, 'updatePaymentDetails'])->middleware('auth:sanctum');

// order details api Route Start

Route::post("/create-order", [OrderController::class, 'OrderCreate'])->middleware('auth:sanctum');

// order details api Route End


// Invoice Api Route Start


Route::get('/invoice-print-receipt', [InvoiceController::class, 'InvoicePrintReceipt']);
Route::get('/invoice-order-payment-details', [InvoiceController::class, 'InvoiceOrderPaymentDetails'])->middleware('auth:sanctum');
Route::post('invoice-payment-details-by-id', [InvoiceController::class, 'InvoicePaymentDetailsByID'])->middleware('auth:sanctum');
Route::post('invoice-payment-details-update', [InvoiceController::class, 'InvoicePaymentDetailsUpdate'])->middleware('auth:sanctum');
Route::post('invoice-full-details-by-id', [InvoiceController::class, 'getInvoiceFullDetailsById'])->middleware('auth:sanctum');
Route::post('update-invoice-details', [InvoiceController::class, 'updateInvoiceDetails'])->middleware('auth:sanctum');


// Invoice Api Route End



// Expense All API Route List Start


// Expense Type:

Route::get("/expense-type-list", [ExpenseTypeController::class, 'ExpenseTypeList'])->middleware('auth:sanctum');
Route::post("/create-expense-type", [ExpenseTypeController::class, 'ExpenseTypeCreate'])->middleware('auth:sanctum');
Route::post("/expense-type-by-id", [ExpenseTypeController::class, 'ExpenseTypeByID'])->middleware('auth:sanctum');
Route::post("/update-expense-type", [ExpenseTypeController::class, 'ExpenseTypeUpdate'])->middleware('auth:sanctum');
Route::post("delete-expense-type", [ExpenseTypeController::class, 'ExpenseTypeDelete'])->middleware('auth:sanctum');

// Expense List:

Route::get("/expense-list", [ExpenseController::class, 'ExpenseList'])->middleware('auth:sanctum');
Route::post("/create-expense", [ExpenseController::class, 'ExpenseCreate'])->middleware('auth:sanctum');
Route::post("/expense-by-id", [ExpenseController::class, 'ExpenseByID'])->middleware('auth:sanctum');
Route::post("/update-expense", [ExpenseController::class, 'ExpenseUpdate'])->middleware('auth:sanctum');
Route::post("delete-expense", [ExpenseController::class, 'ExpenseDelete'])->middleware('auth:sanctum');
Route::get("/staff-list", [ExpenseController::class, 'StaffList'])->middleware('auth:sanctum');
Route::get("/staff-salary-history", [ExpenseController::class, 'StaffSalaryHistory'])->middleware('auth:sanctum');
Route::post("/staff-salary-history", [ExpenseController::class, 'StaffSalaryHistory'])->middleware('auth:sanctum');


// Expense All API Route List End


// Invesment All API Route List Start

// Investor Info API:
Route::get("/investor-info-list", [InvestorInfoController::class, 'InvestorInfoList'])->middleware('auth:sanctum');
Route::post("/create-investor-info", [InvestorInfoController::class, 'InvestorInfoCreate'])->middleware('auth:sanctum');
Route::post("/investor-info-by-id", [InvestorInfoController::class, 'InvestorInfoByID'])->middleware('auth:sanctum');
Route::post("/update-investor-info", [InvestorInfoController::class, 'InvestorInfoUpdate'])->middleware('auth:sanctum');
Route::post("delete-investor-info", [InvestorInfoController::class, 'InvestorInfoDelete'])->middleware('auth:sanctum');


// Invest API:
Route::get("/invest-list", [InvestController::class, 'InvestList'])->middleware('auth:sanctum');
Route::post("/create-invest", [InvestController::class, 'InvestCreate'])->middleware('auth:sanctum');
Route::post("/invest-by-id", [InvestController::class, 'InvestByID'])->middleware('auth:sanctum');
Route::post("/update-invest", [InvestController::class, 'InvestUpdate'])->middleware('auth:sanctum');
Route::post("delete-invest", [InvestController::class, 'InvestDelete'])->middleware('auth:sanctum');

// Invesment All API Route List End



// Report Management Sales Report Start

Route::get("/sales-report-list", [ReportManagementController::class, 'SalesReportList'])->middleware('auth:sanctum');
Route::get("/daily-receipt-payment-report", [ReportManagementController::class, 'DailyReceiptPaymentReport']);
Route::get("/income-expense-report-list", [ReportManagementController::class, 'AllSummeryReport'])->middleware('auth:sanctum');
Route::get("/personal-investor-transaction-report-list", [ReportManagementController::class, 'PersonalInvestorTransactionReport'])->middleware('auth:sanctum');

// Best Selling Products Report API
Route::get('/best-selling-products-report', [ReportManagementController::class, 'BestSellingProductsReport'])->middleware('auth:sanctum');
// Report Management Sales Report End




//Product Return API Start
Route::get("/return-product-list", [ProductReturnController::class, 'ReturnProductList'])->middleware('auth:sanctum');
Route::post("/create-return-product", [ProductReturnController::class, 'ReturnProductCreate'])->middleware('auth:sanctum');
Route::get("/search-invoice-for-return", [ProductReturnController::class, 'SearchInvoiceForReturn'])->middleware('auth:sanctum');


//Purchase Product Return API Start
Route::get("/purchase-return-list", [ProductReturnController::class, 'PurchaseReturnList'])->middleware('auth:sanctum');
Route::get("/search-purchase-for-return", [ProductReturnController::class, 'SearchPurchaseForReturn'])->middleware('auth:sanctum');
Route::post("/create-purchase-return", [ProductReturnController::class, 'PurchaseReturnProductCreate'])->middleware('auth:sanctum');



//Product Return  API End


// This is my district Api Route Start

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/district-list', [DistrictController::class, 'DistrictList']);
    Route::post('/create-district', [DistrictController::class, 'DistrictCreate']);
    Route::post('/district-by-id', [DistrictController::class, 'DistrictByID']);
    Route::post('/update-district', [DistrictController::class, 'DistrictUpdate']);
    Route::post('/delete-district', [DistrictController::class, 'DistrictDelete']);
});
// This is my district Api Route End

// This is my upazila Api Route Start

Route::get("/upazila-list", [UpazilasController::class, 'UpazilaList'])->middleware('auth:sanctum');
Route::post("/create-upazila", [UpazilasController::class, 'UpazilaCreate'])->middleware('auth:sanctum');
Route::post("/upazila-by-id", [UpazilasController::class, 'UpazilaByID'])->middleware('auth:sanctum');
Route::post("/update-upazila", [UpazilasController::class, 'UpazilaUpdate'])->middleware('auth:sanctum');
Route::post("/delete-upazila", [UpazilasController::class, 'UpazilaDelete'])->middleware('auth:sanctum');



// This is my upazila Api Route End

// This is my thana Api Route Start

Route::get("/thana-list", [ThanaController::class, 'ThanaList'])->middleware('auth:sanctum');
Route::post("/create-thana", [ThanaController::class, 'ThanaCreate'])->middleware('auth:sanctum');
Route::post("/thana-by-id", [ThanaController::class, 'ThanaByID'])->middleware('auth:sanctum');
Route::post("/update-thana", [ThanaController::class, 'ThanaUpdate'])->middleware('auth:sanctum');
Route::post("/delete-thana", [ThanaController::class, 'ThanaDelete'])->middleware('auth:sanctum');

// This is my thana Api Route End

// This is my Location Api Route Start

Route::get("/location-list", [LocationController::class, 'LocationList'])->middleware('auth:sanctum');
Route::post("/create-location", [LocationController::class, 'LocationCreate'])->middleware('auth:sanctum');
Route::post("/location-by-id", [LocationController::class, 'LocationById'])->middleware('auth:sanctum');
Route::post("/update-location", [LocationController::class, 'LocationUpdate'])->middleware('auth:sanctum');
Route::post("/delete-location", [LocationController::class, 'LocationDelete'])->middleware('auth:sanctum');

// This is my Location Api Route End


// This is my Opening Balance Api Route Start

Route::middleware('auth:sanctum')->group(function () {

    // Opening Balance CRUD
    Route::get('/opening-balance-list', [OpeningBalanceController::class, 'OpeningBalanceList']);
    Route::post('/create-opening-balance', [OpeningBalanceController::class, 'OpeningBalanceCreate']);
    Route::post('/opening-balance-by-id', [OpeningBalanceController::class, 'OpeningBalanceById']);
    Route::post('/update-opening-balance', [OpeningBalanceController::class, 'OpeningBalanceUpdate']);
    Route::post('/delete-opening-balance', [OpeningBalanceController::class, 'OpeningBalanceDelete']);
});


// This is my Customer Api Route Start



// Customer  route


Route::get("/admin-dashboard-customer-due-collection", [CustomerDueCollectionController::class, 'CustomerDueCollectionList'])->middleware('auth:sanctum');
Route::post("/customer-due-collection-details-by-id", [CustomerDueCollectionController::class, 'CustomerDueCollectionByID'])->middleware('auth:sanctum');
Route::post("/customer-payment-details-update", [CustomerDueCollectionController::class, 'CustomerPaymentDetailsUpdate'])->middleware('auth:sanctum');
Route::post("/customer-due-collection", [CustomerDueCollectionController::class, 'CustomerPaymentDetailsUpdate'])->middleware('auth:sanctum');




Route::get('/customer-invoice-report', [CustomerController::class, 'getCustomerInvoiceReport']);

Route::get("/customer-list", [CustomerController::class, 'CustomerList'])->middleware('auth:sanctum');
Route::get("/customer-due-list", [CustomerController::class, 'CustomerDueList'])->middleware('auth:sanctum');
Route::post("/create-customer", [CustomerController::class, 'CustomerCreate'])->middleware('auth:sanctum');
Route::post("/customer-by-id", [CustomerController::class, 'CustomerByID'])->middleware('auth:sanctum');
Route::post("/update-customer", [CustomerController::class, 'CustomerUpdate'])->middleware('auth:sanctum');
Route::post("/delete-customer", [CustomerController::class, 'CustomerDelete'])->middleware('auth:sanctum');

// কাস্টমারের ইনফরমেশন এবং ইনভয়েস ডাটা আনার জন্য
Route::get('/customer-profile-data/{id}', [App\Http\Controllers\CustomerController::class, 'CustomerProfileData']);

// This is my Customer Api Route End


// Dashboard Report API Start

Route::get("/dashboard-all-calculation", [DashboardController::class, 'DashboardAllCalculation'])->middleware('auth:sanctum');
Route::get('/invoice-order-due-details', [InvoiceController::class, 'InvoiceOrderDuePaymentDetails'])->middleware('auth:sanctum');
Route::get("/stock-out-product-list", [ProductController::class, 'ProductStockOut'])->middleware('auth:sanctum');
Route::get('/daily-ledger-report-list', [ReportManagementController::class, 'DailyLedgerReportList'])->middleware('auth:sanctum');


// Dashboard Report API End

// Dashboard All API Route End
