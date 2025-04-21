<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DetailTransactionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    // Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');

    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/create', [TransactionController::class, 'create'])->name('create');
        Route::post('/store', [TransactionController::class, 'store'])->name('store');
        Route::post('/detail', [TransactionController::class, 'detail'])->name('detail');
        Route::get('/{id}/invoice', [TransactionController::class, 'invoice'])->name('invoice');
        Route::get('/{transaction_id}/member-identity/{phone}', [TransactionController::class, 'memberIdentity'])->name('member-identity');
        Route::post('/update-member', [TransactionController::class, 'updateMember'])->name('update-member');
        Route::delete('/{id}/cancel', [TransactionController::class, 'cancel'])->name('cancel');
    });

    Route::get('/export/transaction/{id}/invoice-pdf', [ExportController::class, 'downloadInvoicePdf'])->name('export.transaction.invoice-pdf');
    Route::get('/export/transactions/excel', [ExportController::class, 'exportTransactionsExcel'])->name('export.transactions.excel');
});

Route::middleware(['role:admin'])->group(function () {
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/update-stock', [ProductController::class, 'updateStock'])->name('updateStock');
    });
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}/update', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::get('/export/products/excel', [ExportController::class, 'exportProductsExcel'])->name('export.products.excel');
});


require __DIR__.'/auth.php';
