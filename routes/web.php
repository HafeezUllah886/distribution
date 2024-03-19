<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\authController;
use App\Http\Controllers\confirmPasswordController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\DepositWithdrawController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\OrderbookerController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalePaymentController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesmanController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UnitsController;
use App\Models\purchase;
use App\Models\transfer;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;


Route::get('/login',[authController::class, 'index'])->name('login');
Route::post('/login',[authController::class, 'login'])->name('signin');

Route::middleware('auth')->group(function (){

    Route::get('/logout', [authController::class, 'logout'])->name('logout');

    Route::get('/profile', [profileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [profileController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/profile/password', [profileController::class, 'updatePassword'])->name('updatePassword');

    Route::get('/', [dashboardController::class, 'index'])->name('dashboard');

    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchaseHistory');
    Route::get('/purchase/create', [PurchaseController::class, 'create'])->name('purchaseCreate');
    Route::post('/purchase/store', [PurchaseController::class, 'store'])->name('purchaseStore');
    Route::post('/purchase/update', [PurchaseController::class, 'update'])->name('purchaseUpdate');
    Route::get('/purchase/view/{id}', [PurchaseController::class, 'show'])->name('purchaseView');
    Route::get('/purchase/edit/{id}', [PurchaseController::class, 'edit'])->name('purchaseEdit');
    Route::get('/singleProduct/{id}', [PurchaseController::class, 'singleProduct'])->name('singleProduct');

    Route::get('/accounts/{filter?}', [AccountController::class, 'index'])->name('accountsIndex');
    Route::post('/account/store', [AccountController::class, 'store'])->name('accountStore');
    Route::post('/account/update', [AccountController::class, 'update'])->name('accountUpdate');
    Route::get('/account/statement/{id}/{start}/{end}', [AccountController::class, 'statement'])->name('accountStatement');

    Route::get('/transfer', [TransferController::class, 'index'])->name('transfers');
    Route::post('/transfer/store', [TransferController::class, 'store'])->name('transferStore');

    Route::get('/depositwithdraw', [DepositWithdrawController::class, 'index'])->name('depositWithdraw');
    Route::post('/depositwithdraw/store', [DepositWithdrawController::class, 'store'])->name('depositWithdrawStore');

    Route::get('/expense', [ExpenseController::class, 'index'])->name('expense');
    Route::post('/expense/store', [ExpenseController::class, 'store'])->name('expenseStore');

    Route::get('/confirm-password', [confirmPasswordController::class, 'showConfirmPasswordForm'])->name('confirm-password');
    Route::post('/confirm-password', [confirmPasswordController::class, 'confirmPassword']);

    Route::get('/products', [ProductsController::class, 'index'])->name('products');
    Route::post('/product/store', [ProductsController::class, 'store'])->name('productStore');
    Route::post('/product/update', [ProductsController::class, 'update'])->name('productUpdate');

    Route::get('/salesman', [SalesmanController::class, 'index'])->name('salesman');
    Route::post('/salesman/store', [SalesmanController::class, 'store'])->name('salesmanStore');
    Route::post('/salesman/update', [SalesmanController::class, 'update'])->name('salesmanUpdate');

    Route::get('/orderbooker', [OrderbookerController::class, 'index'])->name('orderbooker');
    Route::post('/orderbooker/store', [OrderbookerController::class, 'store'])->name('orderbookerStore');
    Route::post('/orderbooker/update', [OrderbookerController::class, 'update'])->name('orderbookerUpdate');

    Route::get('/stocks', [StocksController::class, 'index'])->name('stockIndex');
    Route::get('/stocks/details/{product}/{start}/{end}', [StocksController::class, 'details'])->name('stockDetails');

    Route::get('/units', [UnitsController::class, 'index'])->name('unitIndex');
    Route::post('/units/store', [UnitsController::class, 'store'])->name('unitStore');
    Route::post('/units/update', [UnitsController::class, 'update'])->name('unitUpdate');

    Route::get('/sales', [SalesController::class, 'index'])->name('saleHistory');
    Route::get('/sale/create', [SalesController::class, 'create'])->name('saleCreate');
    Route::post('/sale/store', [SalesController::class, 'store'])->name('saleStore');
    Route::post('/sale/update', [SalesController::class, 'update'])->name('saleUpdate');
    Route::get('/sale/view/{id}', [SalesController::class, 'show'])->name('saleView');
    Route::get('/sale/edit/{id}', [SalesController::class, 'edit'])->name('saleEdit');
    Route::get('/sale/singleProduct/{id}/{customer}', [SalesController::class, 'singleProduct'])->name('saleSingleProduct');

    Route::get('/sale/payments/view/{id}', [SalePaymentController::class, 'payments'])->name('salePaymentsView');
    Route::get('/sale/payments/delete/{ref}', [SalePaymentController::class, 'delete'])->name('salePaymentDelete');
    Route::post('/sale/payments/store', [SalePaymentController::class, 'store'])->name('salePaymentStore');

});

Route::middleware(['confirm.password'])->group(function () {
    Route::get('/transfer/delete/{ref}',[TransferController::class, 'delete'])->name('transferDelete');
    Route::get('/depositwithdraw/delete/{ref}',[DepositWithdrawController::class, 'delete'])->name('depositWithdrawDelete');
    Route::get('/expense/delete/{ref}',[ExpenseController::class, 'delete'])->name('expenseDelete');
    Route::get('/purchase/delete/{id}',[PurchaseController::class, 'delete'])->name('purchaseDelete');
});
