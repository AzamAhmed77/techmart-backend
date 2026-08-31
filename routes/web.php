<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

// Public Landing / Status Page
Route::get('/', function () {
    return view('welcome');
});

// Admin Dashboard Web Portal Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // 1. Overview
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // 2. Orders Management
    Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('orders');
    Route::put('/orders/{id}/status', [AdminDashboardController::class, 'updateOrderStatus'])->name('orders.updateStatus');

    // 3. Products Management (CRUD)
    Route::get('/products', [AdminDashboardController::class, 'products'])->name('products');
    Route::post('/products', [AdminDashboardController::class, 'storeProduct'])->name('products.store');
    Route::put('/products/{id}', [AdminDashboardController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [AdminDashboardController::class, 'deleteProduct'])->name('products.delete');

    // 4. Coupons Management
    Route::get('/coupons', [AdminDashboardController::class, 'coupons'])->name('coupons');
    Route::post('/coupons', [AdminDashboardController::class, 'storeCoupon'])->name('coupons.store');
    Route::post('/coupons/{id}/toggle', [AdminDashboardController::class, 'toggleCoupon'])->name('coupons.toggle');

    // 5. Customers List
    Route::get('/customers', [AdminDashboardController::class, 'customers'])->name('customers');
});

