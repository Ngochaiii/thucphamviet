<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingRates = ShippingRate::orderBy('province')
                                   ->orderBy('city')
                                   ->paginate(15);

        return view('src.admin.shipping-rates.index', compact('shippingRates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.shipping-rates.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'zone_name' => 'required|string|max:255',
            'base_fee' => 'required|numeric|min:0',
            'delivery_days' => 'required|integer|min:1|max:30',
        ], [
            'province.required' => 'Tỉnh/Thành phố là bắt buộc',
            'zone_name.required' => 'Tên vùng là bắt buộc',
            'base_fee.required' => 'Phí ship là bắt buộc',
            'base_fee.numeric' => 'Phí ship phải là số',
            'base_fee.min' => 'Phí ship không được âm',
            'delivery_days.required' => 'Số ngày giao hàng là bắt buộc',
            'delivery_days.integer' => 'Số ngày giao hàng phải là số nguyên',
            'delivery_days.min' => 'Số ngày giao hàng tối thiểu là 1',
            'delivery_days.max' => 'Số ngày giao hàng tối đa là 30',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        // Kiểm tra trùng lặp
        $exists = ShippingRate::where('province', $request->province)
                             ->where('city', $request->city)
                             ->exists();

        if ($exists) {
            return redirect()->back()
                           ->with('error', 'Vùng ship này đã tồn tại!')
                           ->withInput();
        }

        ShippingRate::create($request->all());

        return redirect()->route('admin.shipping-rates.index')
                        ->with('success', 'Thêm vùng ship thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingRate $shippingRate)
    {
        return view('src.admin.shipping-rates.index', compact('shippingRate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingRate $shippingRate)
    {
        $shippingRates = ShippingRate::orderBy('province')
                                   ->orderBy('city')
                                   ->paginate(15);

        return view('src.admin.shipping-rates.index', compact('shippingRates', 'shippingRate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingRate $shippingRate)
    {
        $validator = Validator::make($request->all(), [
            'province' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'zone_name' => 'required|string|max:255',
            'base_fee' => 'required|numeric|min:0',
            'delivery_days' => 'required|integer|min:1|max:30',
        ], [
            'province.required' => 'Tỉnh/Thành phố là bắt buộc',
            'zone_name.required' => 'Tên vùng là bắt buộc',
            'base_fee.required' => 'Phí ship là bắt buộc',
            'base_fee.numeric' => 'Phí ship phải là số',
            'base_fee.min' => 'Phí ship không được âm',
            'delivery_days.required' => 'Số ngày giao hàng là bắt buộc',
            'delivery_days.integer' => 'Số ngày giao hàng phải là số nguyên',
            'delivery_days.min' => 'Số ngày giao hàng tối thiểu là 1',
            'delivery_days.max' => 'Số ngày giao hàng tối đa là 30',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        // Kiểm tra trùng lặp (trừ bản ghi hiện tại)
        $exists = ShippingRate::where('province', $request->province)
                             ->where('city', $request->city)
                             ->where('id', '!=', $shippingRate->id)
                             ->exists();

        if ($exists) {
            return redirect()->back()
                           ->with('error', 'Vùng ship này đã tồn tại!')
                           ->withInput();
        }

        $shippingRate->update($request->all());

        return redirect()->route('admin.shipping-rates.index')
                        ->with('success', 'Cập nhật vùng ship thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingRate $shippingRate)
    {
        $shippingRate->delete();

        return redirect()->route('admin.shipping-rates.index')
                        ->with('success', 'Xóa vùng ship thành công!');
    }

    /**
     * Get shipping fee calculation
     */
    public function calculateFee(Request $request)
    {
        $province = $request->province;
        $city = $request->city;

        $result = ShippingRate::calculateShippingFee($province, $city);

        return response()->json($result);
    }

    /**
     * Get available provinces
     */
    public function getProvinces()
    {
        $provinces = ShippingRate::getAvailableProvinces();
        return response()->json($provinces);
    }

    /**
     * Get cities by province
     */
    public function getCities(Request $request)
    {
        $province = $request->province;
        $cities = ShippingRate::getCitiesByProvince($province);
        return response()->json($cities);
    }
}
