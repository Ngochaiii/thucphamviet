<?php

// routes/admin.php

use App\Http\Controllers\Admin\CategoryController; // Sửa: Admin viết hoa
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;

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

// User routes (nếu có)
// Route::resource('users', UserController::class, ['as' => 'admin']);

// Product routes (nếu có)
// Route::resource('products', ProductController::class, ['as' => 'admin']);

// Order routes (nếu có)
// Route::resource('orders', OrderController::class, ['as' => 'admin']);
