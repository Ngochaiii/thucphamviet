<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $categoryId = $this->route('category') ? $this->route('category')->id : null;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2'
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('categories', 'slug')->ignore($categoryId)
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($categoryId) {
                    // Prevent self-referencing
                    if ($categoryId && $value == $categoryId) {
                        $fail('Danh mục không thể là danh mục cha của chính nó.');
                    }

                    // Prevent circular reference
                    if ($categoryId && $value) {
                        $category = \App\Models\Category::find($categoryId);
                        if ($category && $this->wouldCreateCircularReference($category, $value)) {
                            $fail('Không thể tạo tham chiếu vòng tròn trong cây danh mục.');
                        }
                    }
                }
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048', // 2MB
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
                'max:9999'
            ],
            'is_active' => [
                'nullable',
                'boolean'
            ]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'tên danh mục',
            'slug' => 'slug',
            'parent_id' => 'danh mục cha',
            'description' => 'mô tả',
            'image' => 'hình ảnh',
            'sort_order' => 'thứ tự hiển thị',
            'is_active' => 'trạng thái'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.min' => 'Tên danh mục phải có ít nhất :min ký tự.',
            'name.max' => 'Tên danh mục không được vượt quá :max ký tự.',

            'slug.unique' => 'Slug này đã được sử dụng.',
            'slug.regex' => 'Slug chỉ được chứa chữ thường, số và dấu gạch ngang.',
            'slug.max' => 'Slug không được vượt quá :max ký tự.',

            'parent_id.exists' => 'Danh mục cha không tồn tại.',

            'description.max' => 'Mô tả không được vượt quá :max ký tự.',

            'image.image' => 'File tải lên phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: :values.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá :max KB.',
            'image.dimensions' => 'Hình ảnh phải có kích thước tối thiểu 100x100px và tối đa 2000x2000px.',

            'sort_order.integer' => 'Thứ tự hiển thị phải là số nguyên.',
            'sort_order.min' => 'Thứ tự hiển thị phải lớn hơn hoặc bằng :min.',
            'sort_order.max' => 'Thứ tự hiển thị phải nhỏ hơn hoặc bằng :max.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkbox value to boolean
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);

        // Auto-generate slug if not provided
        if (empty($this->slug) && !empty($this->name)) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->name),
            ]);
        }

        // Set default sort_order
        if (is_null($this->sort_order)) {
            $this->merge([
                'sort_order' => 0,
            ]);
        }
    }

    /**
     * Check if setting parent_id would create a circular reference
     */
    private function wouldCreateCircularReference($category, $parentId): bool
    {
        $parent = \App\Models\Category::find($parentId);

        while ($parent) {
            if ($parent->id === $category->id) {
                return true;
            }
            $parent = $parent->parent;
        }

        return false;
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        // Additional processing after validation passes
        $validated = $this->validated();

        // Unset parent_id if it's empty string
        if (isset($validated['parent_id']) && $validated['parent_id'] === '') {
            $this->merge(['parent_id' => null]);
        }
    }
}
