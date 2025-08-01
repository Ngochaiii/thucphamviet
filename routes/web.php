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

// Profile - Public (tự check trong controller/view)
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/', [AuthController::class, 'updateProfile'])->name('update');
    Route::put('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
});

// Cart - Public (guest cart + user cart)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/{id}', [CartController::class, 'remove'])->name('remove');
});

// Orders - Public (tự check trong controller)
Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{id}', [OrderController::class, 'show'])->name('show');
    Route::post('/', [OrderController::class, 'store'])->name('store');
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

// Tất cả routes khác cũng public...
