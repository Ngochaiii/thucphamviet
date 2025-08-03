<?php

use App\Http\Controllers\Api\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\web\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


// ===== ROUTES =====
// routes/api.php

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'getCart']);
    Route::post('/add', [CartController::class, 'addToCart']);
    Route::put('/item/{itemId}', [CartController::class, 'updateQuantity']);
    Route::delete('/item/{itemId}', [CartController::class, 'removeItem']);
    Route::delete('/clear', [CartController::class, 'clearCart']);
});

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::post('/calculate-shipping', [OrderController::class, 'calculateShipping'])->name('shipping');
    // Có thể thêm các API khác:
    // Route::post('/process-order', [OrderController::class, 'processOrder'])->name('process');
    // Route::get('/payment-methods', [OrderController::class, 'getPaymentMethods'])->name('payment-methods');
});

