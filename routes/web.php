<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DetailTransactionController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/users', function () {
//     return view('admin.user.user');
// })->middleware(['auth', 'verified'])->name('users');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
});

Route::middleware(['role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/add', [UserController::class, 'create'])->name('users.add');
    Route::post('/users/add/data', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit');
    
    Route::get('/product/add', [ProductController::class, 'create'])->name('product.add');
    Route::get('/product/edit', [ProductController::class, 'edit'])->name('product.edit');
});

Route::middleware(['role:cashier'])->group(function () {
    Route::get('/transaction/add', [TransactionController::class, 'create'])->name('transaction.add');
});

// Route::middleware(['role:admin,cashier'])->group(function () {

// });

require __DIR__.'/auth.php';
