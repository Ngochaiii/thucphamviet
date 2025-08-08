<?php

namespace App\Http\Controllers\Web;

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
        $products_2 = Product::where('category_id', 3)
            ->active()
            ->with(['category', 'unit'])
            ->get();
        $products_3 = Product::where('category_id', 4)
            ->active()
            ->with(['category', 'unit'])
            ->get();
        $products_4 = Product::where('category_id', 5)
            ->active()
            ->with(['category', 'unit'])
            ->get();
        $products_5 = Product::where('category_id', 6)
            ->active()
            ->with(['category', 'unit'])
            ->get();
        $products_6 = Product::where('category_id', 7)
            ->active()
            ->with(['category', 'unit'])
            ->get();
        $products_7 = Product::where('category_id', 8)
            ->active()
            ->with(['category', 'unit'])
            ->get();
        return view('src.web.home.index', compact('categories', 'product_best_saling', 'products_1', 'products_2', 'products_3', 'products_4', 'products_5', 'products_6','products_7'));
    }
}
