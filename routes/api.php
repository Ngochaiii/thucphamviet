<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/navigation', [CategoryController::class, 'getNavigation']);
    Route::get('/{id}', [CategoryController::class, 'show']);
});

/*
Các endpoint đơn giản:

1. GET /api/categories
   - Lấy tất cả danh mục cha với children đầy đủ

2. GET /api/categories/navigation
   - Lấy menu navigation tối ưu cho frontend (chỉ thông tin cần thiết)

3. GET /api/categories/{id}
   - Lấy danh mục theo ID với children và parent
*/
