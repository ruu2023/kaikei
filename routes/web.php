<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AppController::class, 'dashboard'])->name('dashboard');
    Route::get('/transaction', [AppController::class, 'transaction'])->name('transaction');
    Route::get('/analytics', [AppController::class, 'analytics'])->name('analytics');
    Route::get('/settings', [AppController::class, 'settings'])->name('settings');

    // category
    Route::post('categories', [CategoryController::class, 'store']);
    Route::patch('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    // paymentMethod
    Route::post('payment-methods', [PaymentMethodController::class, 'store']);
    Route::delete('payment-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy']);

    // client
    Route::post('clients', [ClientController::class, 'store']);
    Route::delete('clients/{client}', [ClientController::class, 'destroy']);

    // transaction
    Route::post('transaction', [TransactionController::class, 'store']);
    Route::delete('transaction/{transaction}', [TransactionController::class, 'destroy']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
