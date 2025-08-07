<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Hiển thị trang danh mục với sản phẩm
     */
    public function show($slug, Request $request)
    {
        $categories = Category::with(['children' => function ($query) {
            $query->where('is_active', true)->orderBy('sort_order');
        }])
        ->where('is_active', true)
        ->whereNull('parent_id')
        ->orderBy('sort_order')
        ->get();

        // Tìm category theo slug
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->with(['children' => function($query) {
                $query->where('is_active', true)->orderBy('sort_order');
            }, 'parent'])
            ->firstOrFail();

        // Lấy tất cả category IDs (bao gồm cả children)
        $categoryIds = $this->getAllCategoryIds($category);

        // Query sản phẩm
        $productsQuery = Product::whereIn('category_id', $categoryIds)
            ->where('status', 'active')
            ->with(['category']);

        // Apply filters
        $this->applyFilters($productsQuery, $request);

        // Pagination
        $perPage = $request->get('per_page', 20);
        $products = $productsQuery->paginate($perPage)->withQueryString();

        // Breadcrumb
        $breadcrumb = $this->buildBreadcrumb($category);

        // Filter options
        $filterOptions = $this->getFilterOptions($categoryIds);

        return view('src.web.category.show', compact(
            'category',
            'products',
            'breadcrumb',
            'filterOptions',
            'categories'
        ));
    }

    /**
     * Lấy tất cả category IDs (bao gồm children)
     */
    private function getAllCategoryIds($category)
    {
        $ids = [$category->id];

        if ($category->children->isNotEmpty()) {
            foreach ($category->children as $child) {
                $ids[] = $child->id;
            }
        }

        return $ids;
    }

    /**
     * Apply filters
     */
    private function applyFilters($query, $request)
    {
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Sort
        switch ($request->get('sort', 'name')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }
    }

    /**
     * Build breadcrumb
     */
    private function buildBreadcrumb($category)
    {
        $breadcrumb = [
            ['name' => 'Trang chủ', 'url' => route('homepage')]
        ];

        if ($category->parent) {
            $breadcrumb[] = [
                'name' => $category->parent->name,
                'url' => route('category.show', $category->parent->slug)
            ];
        }

        $breadcrumb[] = [
            'name' => $category->name,
            'url' => null
        ];

        return $breadcrumb;
    }

    /**
     * Get filter options
     */
    private function getFilterOptions($categoryIds)
{
    return [
        'price_range' => [
            'min' => Product::whereIn('category_id', $categoryIds)->min('price') ?? 0,
            'max' => Product::whereIn('category_id', $categoryIds)->max('price') ?? 1000
        ]
    ];
}
}
