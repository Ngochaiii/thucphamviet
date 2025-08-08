<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = PaymentMethods::systemMethods()
                                       ->orderBy('sort_order')
                                       ->orderBy('name')
                                       ->paginate(15);

        return view('src.admin.payment-methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.payment-methods.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:cod,bank_transfer,credit_card,momo,zalopay,paypal',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'processing_fee' => 'required|numeric|min:0|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'type.required' => 'Loại thanh toán là bắt buộc',
            'type.in' => 'Loại thanh toán không hợp lệ',
            'name.required' => 'Tên phương thức là bắt buộc',
            'processing_fee.required' => 'Phí xử lý là bắt buộc',
            'processing_fee.numeric' => 'Phí xử lý phải là số',
            'processing_fee.min' => 'Phí xử lý không được âm',
            'processing_fee.max' => 'Phí xử lý không được vượt quá 100%',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $request->all();
        $data['user_id'] = null; // System method
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        PaymentMethods::create($data);

        return redirect()->route('admin.payment-methods.index')
                        ->with('success', 'Thêm phương thức thanh toán thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethods $paymentMethod)
    {
        return view('src.admin.payment-methods.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethods $paymentMethod)
    {
        $paymentMethods = PaymentMethods::systemMethods()
                                       ->orderBy('sort_order')
                                       ->orderBy('name')
                                       ->paginate(15);

        return view('src.admin.payment-methods.index', compact('paymentMethods', 'paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethods $paymentMethod)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:cod,bank_transfer,credit_card,momo,zalopay,paypal',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'processing_fee' => 'required|numeric|min:0|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'type.required' => 'Loại thanh toán là bắt buộc',
            'type.in' => 'Loại thanh toán không hợp lệ',
            'name.required' => 'Tên phương thức là bắt buộc',
            'processing_fee.required' => 'Phí xử lý là bắt buộc',
            'processing_fee.numeric' => 'Phí xử lý phải là số',
            'processing_fee.min' => 'Phí xử lý không được âm',
            'processing_fee.max' => 'Phí xử lý không được vượt quá 100%',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $paymentMethod->update($data);

        return redirect()->route('admin.payment-methods.index')
                        ->with('success', 'Cập nhật phương thức thanh toán thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethods $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods.index')
                        ->with('success', 'Xóa phương thức thanh toán thành công!');
    }

    /**
     * Toggle status
     */
    public function toggleStatus(PaymentMethods $paymentMethod)
    {
        $paymentMethod->update([
            'is_active' => !$paymentMethod->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công!'
        ]);
    }
}
