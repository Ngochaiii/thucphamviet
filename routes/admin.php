<?php

// routes/admin.php

use App\Http\Controllers\Admin\CategoryController; // Sửa: Admin viết hoa
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\admin\PaymentMethodController;
use App\Http\Controllers\admin\ShippingRateController;
use App\Http\Controllers\Admin\UnitController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| File này đã được load trong RouteServiceProvider với:
| - middleware: ['web', 'auth', 'admin']
| - prefix: 'admin'
| - Vì vậy KHÔNG cần thêm middleware và prefix nữa
*/

// Dashboard routes
Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

// Category routes - Không cần middleware vì đã có trong RouteServiceProvider
Route::group(['prefix' => 'categories', 'as' => 'admin.categories.'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/', [CategoryController::class, 'store'])->name('store');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    Route::post('/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('toggle-status');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
});

// Units Routes (new)
Route::group(['prefix' => 'units', 'as' => 'admin.units.'], function () {
    Route::get('/', [UnitController::class, 'index'])->name('index');
    Route::get('/create', [UnitController::class, 'create'])->name('create');
    Route::post('/', [UnitController::class, 'store'])->name('store');
    Route::get('/{unit}/edit', [UnitController::class, 'edit'])->name('edit');
    Route::put('/{unit}', [UnitController::class, 'update'])->name('update');
    Route::delete('/{unit}', [UnitController::class, 'destroy'])->name('destroy');
    Route::post('/{unit}/toggle-status', [UnitController::class, 'toggleStatus'])->name('toggle-status');
    Route::get('/{unit}', [UnitController::class, 'show'])->name('show');
});
// Product routes
Route::group(['prefix' => 'products', 'as' => 'admin.products.'], function () {
    // Main CRUD routes
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');

    // Additional product-specific routes
    Route::post('/bulk-update-status', [ProductController::class, 'bulkUpdateStatus'])->name('bulk-update-status');
    Route::delete('/bulk-delete', [ProductController::class, 'bulkDelete'])->name('bulk-delete');
    Route::get('/search/ajax', [ProductController::class, 'search'])->name('search');
    Route::get('/statistics/ajax', [ProductController::class, 'statistics'])->name('statistics');
    Route::post('/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('toggle-status');
    Route::post('/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('toggle-featured');
    Route::post('/{product}/update-rating', [ProductController::class, 'updateRating'])->name('update-rating');
});
// Shipping Rates Routes
Route::group(['prefix' => 'shipping-rates', 'as' => 'admin.shipping-rates.'], function () {
    Route::get('/', [ShippingRateController::class, 'index'])->name('index');
    Route::get('/create', [ShippingRateController::class, 'create'])->name('create');
    Route::post('/', [ShippingRateController::class, 'store'])->name('store');
    Route::get('/{shippingRate}/edit', [ShippingRateController::class, 'edit'])->name('edit');
    Route::put('/{shippingRate}', [ShippingRateController::class, 'update'])->name('update');
    Route::delete('/{shippingRate}', [ShippingRateController::class, 'destroy'])->name('destroy');
    Route::get('/{shippingRate}', [ShippingRateController::class, 'show'])->name('show');

    // Additional API routes for shipping calculations
    Route::post('/calculate-fee', [ShippingRateController::class, 'calculateFee'])->name('calculate-fee');
    Route::get('/provinces', [ShippingRateController::class, 'getProvinces'])->name('provinces');
    Route::get('/cities/{province}', [ShippingRateController::class, 'getCities'])->name('cities');
});

// Payment Methods Routes
Route::group(['prefix' => 'payment-methods', 'as' => 'admin.payment-methods.'], function () {
    Route::get('/', [PaymentMethodController::class, 'index'])->name('index');
    Route::get('/create', [PaymentMethodController::class, 'create'])->name('create');
    Route::post('/', [PaymentMethodController::class, 'store'])->name('store');
    Route::get('/{paymentMethod}/edit', [PaymentMethodController::class, 'edit'])->name('edit');
    Route::put('/{paymentMethod}', [PaymentMethodController::class, 'update'])->name('update');
    Route::delete('/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('destroy');

    // Toggle status
    Route::post('/{paymentMethod}/toggle-status', [PaymentMethodController::class, 'toggleStatus'])->name('toggle-status');
});
