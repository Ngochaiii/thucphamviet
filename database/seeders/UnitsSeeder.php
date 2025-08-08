<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'name' => 'Cái',
                'symbol' => 'cái',
                'description' => 'Đơn vị đếm cái - dùng cho các sản phẩm đếm được',
            ],
            [
                'name' => 'Chiếc',
                'symbol' => 'chiếc',
                'description' => 'Đơn vị đếm chiếc - dùng cho xe, máy móc, thiết bị',
            ],
            [
                'name' => 'Bộ',
                'symbol' => 'bộ',
                'description' => 'Đơn vị tính bộ - dùng cho sản phẩm có nhiều chi tiết',
            ],
            [
                'name' => 'Hộp',
                'symbol' => 'hộp',
                'description' => 'Đơn vị đóng gói hộp - dùng cho sản phẩm đóng hộp',
            ],
            [
                'name' => 'Thùng',
                'symbol' => 'thùng',
                'description' => 'Đơn vị đóng gói thùng - dùng cho sản phẩm đóng thùng',
            ],
            [
                'name' => 'Chai',
                'symbol' => 'chai',
                'description' => 'Đơn vị đóng chai - dùng cho chất lỏng đóng chai',
            ],
            [
                'name' => 'Lon',
                'symbol' => 'lon',
                'description' => 'Đơn vị đóng lon - dùng cho đồ uống, thực phẩm đóng lon',
            ],
            [
                'name' => 'Túi',
                'symbol' => 'túi',
                'description' => 'Đơn vị đóng túi - dùng cho sản phẩm đóng túi',
            ],
            [
                'name' => 'Gói',
                'symbol' => 'gói',
                'description' => 'Đơn vị đóng gói - dùng cho sản phẩm đóng gói nhỏ',
            ],
            [
                'name' => 'Kilogram',
                'symbol' => 'kg',
                'description' => 'Đơn vị khối lượng - 1000 gram',
            ],
            [
                'name' => 'Gram',
                'symbol' => 'g',
                'description' => 'Đơn vị khối lượng cơ bản',
            ],
            [
                'name' => 'Tấn',
                'symbol' => 'tấn',
                'description' => 'Đơn vị khối lượng lớn - 1000 kg',
            ],
            [
                'name' => 'Lít',
                'symbol' => 'l',
                'description' => 'Đơn vị thể tích chất lỏng',
            ],
            [
                'name' => 'Millilít',
                'symbol' => 'ml',
                'description' => 'Đơn vị thể tích nhỏ - 1/1000 lít',
            ],
            [
                'name' => 'Mét',
                'symbol' => 'm',
                'description' => 'Đơn vị chiều dài cơ bản',
            ],
            [
                'name' => 'Centimét',
                'symbol' => 'cm',
                'description' => 'Đơn vị chiều dài - 1/100 mét',
            ],
            [
                'name' => 'Mét vuông',
                'symbol' => 'm²',
                'description' => 'Đơn vị diện tích',
            ],
            [
                'name' => 'Mét khối',
                'symbol' => 'm³',
                'description' => 'Đơn vị thể tích không gian',
            ],
            [
                'name' => 'Viên',
                'symbol' => 'viên',
                'description' => 'Đơn vị đếm viên - dùng cho thuốc, kẹo',
            ],
            [
                'name' => 'Hạt',
                'symbol' => 'hạt',
                'description' => 'Đơn vị đếm hạt - dùng cho hạt giống, ngũ cốc',
            ],
            [
                'name' => 'Cuộn',
                'symbol' => 'cuộn',
                'description' => 'Đơn vị đếm cuộn - dùng cho giấy, vải, dây',
            ],
            [
                'name' => 'Tờ',
                'symbol' => 'tờ',
                'description' => 'Đơn vị đếm tờ - dùng cho giấy, tài liệu',
            ],
            [
                'name' => 'Quyển',
                'symbol' => 'quyển',
                'description' => 'Đơn vị đếm quyển - dùng cho sách, tạp chí',
            ],
            [
                'name' => 'Cặp',
                'symbol' => 'cặp',
                'description' => 'Đơn vị đếm cặp - dùng cho giày, tất, găng tay',
            ],
            [
                'name' => 'Đơn vị',
                'symbol' => 'đvt',
                'description' => 'Đơn vị tính chung - dùng khi không có đơn vị cụ thể',
            ],
        ];

        foreach ($units as $unitData) {
            Unit::firstOrCreate(
                ['name' => $unitData['name']], // Điều kiện kiểm tra
                [
                    'symbol' => $unitData['symbol'],
                    'description' => $unitData['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}
