<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->getAllWithFilters($request, 15);
        $categories = $this->productRepository->getCategories();

        return view('src.admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->productRepository->getCategories();
        $units = $this->productRepository->getUnits();
        $currencies = $this->productRepository->getSupportedCurrencies();

        return view('src.admin.products.create', compact('categories', 'units', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->validateProduct($request);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->all();
            $this->productRepository->create($data);

            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = $this->productRepository->findById($id);
        return view('src.admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = $this->productRepository->findById($id);
        $categories = $this->productRepository->getCategories();
        $units = $this->productRepository->getUnits();
        $currencies = $this->productRepository->getSupportedCurrencies();

        return view('src.admin.products.edit', compact('product', 'categories', 'units', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validateProduct($request, $id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->all();
            $this->productRepository->update($id, $data);

            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->productRepository->delete($id);

            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Bulk update status
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $this->productRepository->bulkUpdateStatus($request->ids, $request->status);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete products
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        try {
            foreach ($request->ids as $id) {
                $this->productRepository->delete($id);
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Đã xóa ' . count($request->ids) . ' sản phẩm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Toggle product status
     */
    public function toggleStatus($id)
    {
        try {
            $product = $this->productRepository->findById($id);
            $newStatus = $product->status === 'active' ? 'inactive' : 'active';

            $this->productRepository->update($id, ['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công!',
                'status' => $newStatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
    {
        try {
            $product = $this->productRepository->findById($id);
            $newFeatured = !$product->is_featured;

            $this->productRepository->update($id, ['is_featured' => $newFeatured]);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái nổi bật thành công!',
                'is_featured' => $newFeatured
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update product rating manually
     */
    public function updateRating($id)
    {
        try {
            $product = $this->productRepository->updateRating($id);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật đánh giá thành công!',
                'rating_avg' => $product->rating_avg,
                'rating_count' => $product->rating_count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get product statistics
     */
    public function statistics()
    {
        $statistics = $this->productRepository->getStatistics();
        return response()->json($statistics);
    }

    /**
     * Search products (AJAX)
     */
    public function search(Request $request)
    {
        $keyword = $request->get('q');
        $products = $this->productRepository->search($keyword, 10);

        return response()->json([
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'jp_name' => $product->jp_name,
                    'price' => $product->price,
                    'image' => $product->image ? asset('storage/' . $product->image) : null,
                ];
            })
        ]);
    }

    /**
     * Validate product data
     */
    private function validateProduct(Request $request, $id = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'jp_name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug' . ($id ? ",$id" : ''),
            'description' => 'nullable|string',
            'specification' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'quantity' => 'required|integer|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive',
            'category_id' => 'nullable|exists:categories,id',
            'unit_id' => 'nullable|exists:units,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'nullable|boolean',
        ];

        $messages = [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
            'jp_name.max' => 'Tên tiếng Nhật không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug này đã được sử dụng.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'price.required' => 'Giá bán là bắt buộc.',
            'price.numeric' => 'Giá bán phải là số.',
            'price.min' => 'Giá bán phải lớn hơn hoặc bằng 0.',
            'currency.required' => 'Loại tiền tệ là bắt buộc.',
            'currency.size' => 'Mã tiền tệ phải có 3 ký tự.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 0.',
            'discount.numeric' => 'Giảm giá phải là số.',
            'discount.min' => 'Giảm giá phải lớn hơn hoặc bằng 0.',
            'discount.max' => 'Giảm giá không được vượt quá 100%.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'category_id.exists' => 'Danh mục không tồn tại.',
            'unit_id.exists' => 'Đơn vị không tồn tại.',
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'images.*.image' => 'File phải là hình ảnh.',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }
}
