<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị trang tất cả sản phẩm với phân chia theo danh mục
     */
    public function allProducts(Request $request)
    {
        // Lấy tham số từ request
        $categoryId = $request->get('category');
        $search = $request->get('search');
        $sortBy = $request->get('sort', 'name'); // Mặc định sắp xếp theo tên
        $sortOrder = $request->get('order', 'asc'); // Mặc định tăng dần
        $perPage = $request->get('per_page', 12); // Số sản phẩm trên mỗi trang

        // Lấy tất cả danh mục cha để hiển thị filter
        $categories = Category::active()
            ->parentOnly()
            ->ordered()
            ->withCount(['products' => function($query) {
                $query->active()->inStock();
            }])
            ->get();

        // Query sản phẩm
        $productsQuery = Product::active()
            ->inStock()
            ->with(['category', 'unit']);

        // Lọc theo danh mục nếu có
        if ($categoryId) {
            $selectedCategory = Category::find($categoryId);
            if ($selectedCategory) {
                // Nếu là danh mục cha, lấy cả sản phẩm của danh mục con
                if ($selectedCategory->is_parent) {
                    $categoryIds = $selectedCategory->children()->pluck('id')->push($categoryId);
                    $productsQuery->whereIn('category_id', $categoryIds);
                } else {
                    $productsQuery->byCategory($categoryId);
                }
            }
        }

        // Tìm kiếm nếu có
        if ($search) {
            $productsQuery->search($search);
        }

        // Sắp xếp
        switch ($sortBy) {
            case 'price':
                $productsQuery->orderBy('price', $sortOrder);
                break;
            case 'discount':
                $productsQuery->orderBy('discount', 'desc');
                break;
            case 'rating':
                $productsQuery->orderBy('rating_avg', 'desc');
                break;
            case 'newest':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            default:
                $productsQuery->orderBy('name', $sortOrder);
        }

        // Phân trang
        $products = $productsQuery->paginate($perPage);

        // Lấy danh mục được chọn
        $selectedCategory = $categoryId ? Category::find($categoryId) : null;

        return view('src.web.products.index', compact(
            'products',
            'categories',
            'selectedCategory',
            'search',
            'sortBy',
            'sortOrder',
            'perPage'
        ));
    }

    /**
     * Hiển thị sản phẩm theo danh mục cụ thể
     */
    public function byCategory(Request $request, $categorySlug)
    {
        $category = Category::active()
            ->where('slug', $categorySlug)
            ->firstOrFail();

        // Redirect đến trang all products với filter category
        return redirect()->route('products.all', ['category' => $category->id]);
    }

    /**
     * Hiển thị chi tiết sản phẩm
     */
    public function show($slug)
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->with(['category', 'unit', 'approvedReviews.user'])
            ->firstOrFail();

        // Sản phẩm liên quan cùng danh mục
        $relatedProducts = Product::active()
            ->inStock()
            ->byCategory($product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(8)
            ->get();

        return view('src.web.products.index', compact('product', 'relatedProducts'));
    }

    /**
     * API endpoint để lấy sản phẩm theo AJAX
     */
    public function getProductsAjax(Request $request)
    {
        $categoryId = $request->get('category');
        $search = $request->get('search');
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 12);

        $productsQuery = Product::active()
            ->inStock()
            ->with(['category', 'unit']);

        if ($categoryId) {
            $selectedCategory = Category::find($categoryId);
            if ($selectedCategory && $selectedCategory->is_parent) {
                $categoryIds = $selectedCategory->children()->pluck('id')->push($categoryId);
                $productsQuery->whereIn('category_id', $categoryIds);
            } else {
                $productsQuery->byCategory($categoryId);
            }
        }

        if ($search) {
            $productsQuery->search($search);
        }

        switch ($sortBy) {
            case 'price':
                $productsQuery->orderBy('price', $sortOrder);
                break;
            case 'discount':
                $productsQuery->orderBy('discount', 'desc');
                break;
            case 'rating':
                $productsQuery->orderBy('rating_avg', 'desc');
                break;
            case 'newest':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            default:
                $productsQuery->orderBy('name', $sortOrder);
        }

        $products = $productsQuery->paginate($perPage);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total()
                ]
            ]);
        }

        return $products;
    }
}
