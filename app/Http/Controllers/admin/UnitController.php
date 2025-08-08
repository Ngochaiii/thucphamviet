<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::orderBy('name')->paginate(20);
        return view('src.admin.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('src.admin.units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name',
            'symbol' => 'required|string|max:20|unique:units,symbol',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $unit = Unit::create([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.units.index')
            ->with('success', 'Đơn vị đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        return view('src.admin.units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return view('src.admin.units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name,' . $unit->id,
            'symbol' => 'required|string|max:20|unique:units,symbol,' . $unit->id,
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $unit->update([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.units.index')
            ->with('success', 'Đơn vị đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        // Check if unit has products
        if ($unit->products()->count() > 0) {
            return redirect()->route('admin.units.index')
                ->with('error', 'Không thể xóa đơn vị này vì đang có sản phẩm sử dụng!');
        }

        $unit->delete();

        return redirect()->route('admin.units.index')
            ->with('success', 'Đơn vị đã được xóa thành công!');
    }

    /**
     * Toggle status of the unit
     */
    public function toggleStatus(Unit $unit)
    {
        $unit->update(['is_active' => !$unit->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Trạng thái đơn vị đã được cập nhật!',
            'is_active' => $unit->is_active
        ]);
    }
}
