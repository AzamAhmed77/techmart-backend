<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserPreferencesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - TECH MART
|--------------------------------------------------------------------------
|
| Secured with Rate Limiting, Sanctum Token Auth, and User Isolation.
|
*/

// Public Health Check
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'app' => 'TECH MART API', 'timestamp' => now()->toIso8601String()]);
});

// Auto-seed Endpoint (fills rich categories & products)
Route::get('/seed-database', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    $categoriesCount = \App\Models\Product::distinct('category')->count('category');
    $productsCount = \App\Models\Product::count();
    return response()->json([
        'status' => 'success',
        'message' => 'تم تعبئة المنتجات والفئات بنجاح',
        'categories_count' => $categoriesCount,
        'products_count' => $productsCount,
    ]);
});

// Public Authentication Routes (Protected with Throttle 120 req/min)
Route::middleware('throttle:120,1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Password Recovery & OTP & Email Verification (Throttle 60 req/min)
Route::middleware('throttle:60,1')->group(function () {
    Route::post('/register/verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('/register/resend-email', [AuthController::class, 'resendVerificationEmail']);
    Route::post('/forgot-password', [PasswordResetController::class, 'sendOtp']);
    Route::post('/verify-code', [PasswordResetController::class, 'verifyOtp']);
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
});

// Public Products & Categories Routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/categories', [ProductController::class, 'categories']);
Route::get('/products/{id}/reviews', [ReviewController::class, 'getProductReviews']);

// Public Active Coupons (for promo banners)
Route::get('/coupons/active', [CouponController::class, 'getActiveCoupons']);

// Protected Routes (Require Token Authentication & Multi-User Isolation)
Route::middleware('auth:sanctum')->group(function () {
    // User Profile
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user/profile', [UserPreferencesController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // User Isolated Favorites
    Route::get('/favorites', [UserPreferencesController::class, 'getFavorites']);
    Route::post('/favorites/toggle', [UserPreferencesController::class, 'toggleFavorite']);

    // User Isolated Cart
    Route::get('/cart', [UserPreferencesController::class, 'getCart']);
    Route::post('/cart/add', [UserPreferencesController::class, 'addToCart']);
    Route::post('/cart/update-quantity', [UserPreferencesController::class, 'updateCartQuantity']);
    Route::delete('/cart/{productId}', [UserPreferencesController::class, 'removeFromCart']);
    Route::delete('/cart', [UserPreferencesController::class, 'clearCart']);

    // Orders & Checkout
    Route::post('/orders', [OrderController::class, 'createOrder']);
    Route::get('/orders', [OrderController::class, 'getOrders']);
    Route::get('/orders/{id}', [OrderController::class, 'getOrderDetails']);
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancelOrder']);

    // Coupons
    Route::post('/coupons/validate', [CouponController::class, 'validateCoupon']);

    // Product Reviews
    Route::post('/reviews', [ReviewController::class, 'addReview']);

    // Shipping Addresses
    Route::get('/addresses', [AddressController::class, 'getAddresses']);
    Route::post('/addresses', [AddressController::class, 'saveAddress']);
    Route::delete('/addresses/{id}', [AddressController::class, 'deleteAddress']);
    Route::post('/addresses/{id}/default', [AddressController::class, 'setDefault']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'getNotifications']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
});
