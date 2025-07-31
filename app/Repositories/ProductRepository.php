<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use App\Helpers\CurrencyHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class ProductRepository
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * Get all products with pagination and filters
     */
    public function getAllWithFilters(Request $request, $perPage = 15)
    {
        $query = $this->model->with(['category', 'unit']);

        // Search filters
        if ($request->filled('searchText')) {
            $searchText = $request->searchText;
            $searchBy = $request->searchBy ?? 'name';

            switch ($searchBy) {
                case 'name':
                    $query->where('name', 'like', "%{$searchText}%")
                        ->orWhere('jp_name', 'like', "%{$searchText}%");
                    break;
                case 'description':
                    $query->where('description', 'like', "%{$searchText}%");
                    break;
                default:
                    $query->where($searchBy, 'like', "%{$searchText}%");
                    break;
            }
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Featured filter
        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->is_featured);
        }

        // Sorting
        $sortBy = $request->sortBy ?? 'id';
        $orderBy = $request->orderBy ?? 'desc';
        $query->orderBy($sortBy, $orderBy);

        return $query->paginate($perPage);
    }

    /**
     * Get product by ID
     */
    public function findById($id)
    {
        return $this->model->with(['category', 'unit'])->findOrFail($id);
    }

    /**
     * Create new product
     */
    public function create(array $data)
    {
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Ensure slug is unique
        $data['slug'] = $this->makeSlugUnique($data['slug']);

        // Handle image upload
        if (isset($data['image']) && $data['image']) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        // Handle multiple images upload
        if (isset($data['images']) && is_array($data['images'])) {
            $uploadedImages = [];
            foreach ($data['images'] as $image) {
                $uploadedImages[] = $this->uploadImage($image);
            }
            $data['images'] = $uploadedImages;
        }

        // Set default values
        $data['rating_avg'] = 0;
        $data['rating_count'] = 0;
        $data['is_featured'] = isset($data['is_featured']) ? true : false;
        $data['currency'] = $data['currency'] ?? CurrencyHelper::getDefaultCurrency();

        return $this->model->create($data);
    }

    /**
     * Update product
     */
    public function update($id, array $data)
    {
        $product = $this->findById($id);

        // Generate slug if name changed and slug is empty
        if (isset($data['name']) && (empty($data['slug']) || $data['slug'] === $product->slug)) {
            $data['slug'] = Str::slug($data['name']);
            $data['slug'] = $this->makeSlugUnique($data['slug'], $id);
        }

        // Handle image upload
        if (isset($data['image']) && $data['image']) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $this->uploadImage($data['image']);
        }

        // Handle multiple images upload
        if (isset($data['images']) && is_array($data['images'])) {
            // Delete old images
            if ($product->images) {
                foreach ($product->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $uploadedImages = [];
            foreach ($data['images'] as $image) {
                $uploadedImages[] = $this->uploadImage($image);
            }
            $data['images'] = $uploadedImages;
        }

        // Handle boolean fields
        $data['is_featured'] = isset($data['is_featured']) ? true : false;

        // Set currency if not provided
        if (!isset($data['currency'])) {
            $data['currency'] = $product->currency ?? CurrencyHelper::getDefaultCurrency();
        }

        $product->update($data);
        return $product;
    }

    /**
     * Delete product
     */
    public function delete($id)
    {
        $product = $this->findById($id);

        // Delete images
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        return $product->delete();
    }

    /**
     * Get categories for dropdown
     */
    public function getCategories()
    {
        // Category model sử dụng is_active thay vì status
        return Category::active()->orderBy('name')->get();
    }

    /**
     * Get units for dropdown
     */
    public function getUnits()
    {
        return Unit::active()->orderBy('name')->get();
    }

    /**
     * Get active products
     */
    public function getActiveProducts()
    {
        return $this->model->active()->orderBy('name')->get();
    }

    /**
     * Get featured products
     */
    public function getFeaturedProducts($limit = null)
    {
        $query = $this->model->featured()->active()->with(['category', 'unit']);

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Search products
     */
    public function search($keyword, $limit = null)
    {
        $query = $this->model->search($keyword)->active()->with(['category', 'unit']);

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Upload image
     */
    private function uploadImage($image)
    {
        return $image->store('products', 'public');
    }

    /**
     * Make slug unique
     */
    private function makeSlugUnique($slug, $excludeId = null)
    {
        $originalSlug = $slug;
        $count = 1;

        while ($this->slugExists($slug, $excludeId)) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Check if slug exists
     */
    private function slugExists($slug, $excludeId = null)
    {
        $query = $this->model->where('slug', $slug);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Update product rating
     */
    public function updateRating($productId)
    {
        $product = $this->findById($productId);
        $product->updateRating();
        return $product;
    }

    /**
     * Get products by category
     */
    public function getByCategory($categoryId, $limit = null)
    {
        $query = $this->model->byCategory($categoryId)->active()->with(['category', 'unit']);

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get in stock products
     */
    public function getInStockProducts()
    {
        return $this->model->inStock()->active()->with(['category', 'unit'])->get();
    }

    /**
     * Bulk update status
     */
    public function bulkUpdateStatus(array $ids, $status)
    {
        return $this->model->whereIn('id', $ids)->update(['status' => $status]);
    }

    /**
     * Get product statistics
     */
    public function getStatistics()
    {
        return [
            'total' => $this->model->count(),
            'active' => $this->model->where('status', 'active')->count(),
            'inactive' => $this->model->where('status', 'inactive')->count(),
            'featured' => $this->model->where('is_featured', true)->count(),
            'out_of_stock' => $this->model->where('quantity', 0)->count(),
        ];
    }

    /**
     * Toggle product status
     */
    public function toggleStatus($id)
    {
        $product = $this->findById($id);
        $newStatus = $product->status === 'active' ? 'inactive' : 'active';

        return $this->update($id, ['status' => $newStatus]);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
    {
        $product = $this->findById($id);
        $newFeatured = !$product->is_featured;

        return $this->update($id, ['is_featured' => $newFeatured]);
    }

    /**
     * Get products by status
     */
    public function getByStatus($status)
    {
        return $this->model->where('status', $status)->with(['category', 'unit'])->get();
    }

    /**
     * Get low stock products
     */
    public function getLowStockProducts($threshold = 10)
    {
        return $this->model->where('quantity', '<=', $threshold)
            ->where('quantity', '>', 0)
            ->with(['category', 'unit'])
            ->get();
    }

    /**
     * Get products without images
     */
    public function getProductsWithoutImages()
    {
        return $this->model->whereNull('image')
            ->orWhere('image', '')
            ->with(['category', 'unit'])
            ->get();
    }

    /**
     * Get recently added products
     */
    public function getRecentlyAdded($days = 7, $limit = null)
    {
        $query = $this->model->where('created_at', '>=', now()->subDays($days))
            ->with(['category', 'unit'])
            ->orderBy('created_at', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get products needing attention (low stock, no image, inactive)
     */
    public function getProductsNeedingAttention()
    {
        return [
            'low_stock' => $this->getLowStockProducts(5)->count(),
            'no_image' => $this->getProductsWithoutImages()->count(),
            'inactive' => $this->getByStatus('inactive')->count(),
            'no_category' => $this->model->whereNull('category_id')->count(),
        ];
    }
    public function formatProductPrice($product)
    {
        return CurrencyHelper::formatPrice($product->price, $product->currency);
    }
    public function getSupportedCurrencies()
    {
        return CurrencyHelper::getCurrencyOptions();
    }
}
