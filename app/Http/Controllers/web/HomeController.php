<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy categories để truyền cho view
        $categories = Category::with(['children' => function ($query) {
            $query->where('is_active', true)->orderBy('sort_order');
        }])
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();
        $product_best_saling = Product::where('is_featured', true)->get();
        // Lấy sản phẩm của category 1
        $products_1 = Product::where('category_id', 2)
            ->active()
            ->with(['category', 'unit'])
            ->get();
        return view('src.web.home.index', compact('categories', 'product_best_saling','products_1'));
    }
}
