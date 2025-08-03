<?php

// routes/web.php - Frontend routes (Tất cả public)

use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| PUBLIC FRONTEND ROUTES - Không cần đăng nhập
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('homepage');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

// Dashboard - Public (hiển thị khác nhau tùy đăng nhập hay không)
Route::get('/dashboard', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->is_admin) {
            return view('dashboard.admin-frontend', compact('user'));
        }
        return view('dashboard.customer', compact('user'));
    }
    // Chưa đăng nhập - hiển thị guest dashboard
    return view('dashboard.guest');
})->name('dashboard');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::put('/cart/item/{itemId}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/item/{itemId}', [CartController::class, 'removeItem'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');


// // Cart - Public (guest cart + user cart)
// Route::prefix('cart')->name('cart.')->group(function () {
//     Route::get('/', [CartController::class, 'index'])->name('index');
//     Route::post('/add', [CartController::class, 'add'])->name('add');
//     Route::put('/{id}', [CartController::class, 'update'])->name('update');
//     Route::delete('/{id}', [CartController::class, 'remove'])->name('remove');
// });

// Product Routes
Route::prefix('products')->name('products.')->group(function () {
    // Trang tất cả sản phẩm
    Route::get('/', [ProductController::class, 'allProducts'])->name('all');

    // API endpoint cho AJAX (nếu cần)
    Route::get('/ajax', [ProductController::class, 'getProductsAjax'])->name('ajax');

    // Sản phẩm theo danh mục (redirect đến all products với filter)
    Route::get('/category/{categorySlug}', [ProductController::class, 'byCategory'])->name('by-category');

    // Chi tiết sản phẩm
    Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
});
// Contact, About, etc - Public
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Wishlist - Public
Route::get('/wishlist', function () {
    return view('wishlist.index');
})->name('wishlist');

// Checkout - Public (guest checkout)
Route::get('/checkout', function () {
    return view('checkout.index');
})->name('checkout');

// Product Routes
Route::prefix('order')->name('order.')->group(function () {
    // Trang tất cả sản phẩm
    Route::get('/', [OrderController::class, 'index'])->name('all');
});

