<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethods;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            // Cash on Delivery only for now
            [
                'type' => 'cod',
                'name' => 'Cash on Delivery',
                'description' => 'Thanh toán tiền mặt khi nhận hàng (COD)',
                'processing_fee' => 0.00,
                'sort_order' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethods::updateOrCreate(
                [
                    'type' => $method['type'],
                    'name' => $method['name'],
                ],
                array_merge($method, ['user_id' => null]) // System methods
            );
        }

        $this->command->info('Payment methods seeded successfully! Total: ' . count($paymentMethods) . ' records.');
    }
}
