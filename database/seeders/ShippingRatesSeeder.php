<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShippingRate;

class ShippingRatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shippingData = [
            // Kanto Region (関東地方) - Tokyo and surrounding areas
            [
                'province' => 'Tokyo',
                'city' => null,
                'zone_name' => 'Tokyo Metropolitan Area',
                'base_fee' => 500.00,
                'delivery_days' => 1,
            ],
            [
                'province' => 'Tokyo',
                'city' => 'Shibuya',
                'zone_name' => 'Central Tokyo',
                'base_fee' => 450.00,
                'delivery_days' => 1,
            ],
            [
                'province' => 'Tokyo',
                'city' => 'Shinjuku',
                'zone_name' => 'Central Tokyo',
                'base_fee' => 450.00,
                'delivery_days' => 1,
            ],
            [
                'province' => 'Kanagawa',
                'city' => null,
                'zone_name' => 'Kanto Region',
                'base_fee' => 550.00,
                'delivery_days' => 1,
            ],
            [
                'province' => 'Kanagawa',
                'city' => 'Yokohama',
                'zone_name' => 'Major City',
                'base_fee' => 500.00,
                'delivery_days' => 1,
            ],
            [
                'province' => 'Saitama',
                'city' => null,
                'zone_name' => 'Kanto Region',
                'base_fee' => 600.00,
                'delivery_days' => 2,
            ],
            [
                'province' => 'Chiba',
                'city' => null,
                'zone_name' => 'Kanto Region',
                'base_fee' => 600.00,
                'delivery_days' => 2,
            ],

            // Kansai Region (関西地方) - Osaka, Kyoto, Kobe
            [
                'province' => 'Osaka',
                'city' => null,
                'zone_name' => 'Kansai Region',
                'base_fee' => 650.00,
                'delivery_days' => 2,
            ],
            [
                'province' => 'Osaka',
                'city' => 'Osaka City',
                'zone_name' => 'Major City',
                'base_fee' => 600.00,
                'delivery_days' => 2,
            ],
            [
                'province' => 'Kyoto',
                'city' => null,
                'zone_name' => 'Kansai Region',
                'base_fee' => 650.00,
                'delivery_days' => 2,
            ],
            [
                'province' => 'Kyoto',
                'city' => 'Kyoto City',
                'zone_name' => 'Historic City',
                'base_fee' => 600.00,
                'delivery_days' => 2,
            ],
            [
                'province' => 'Hyogo',
                'city' => null,
                'zone_name' => 'Kansai Region',
                'base_fee' => 700.00,
                'delivery_days' => 3,
            ],
            [
                'province' => 'Hyogo',
                'city' => 'Kobe',
                'zone_name' => 'Port City',
                'base_fee' => 650.00,
                'delivery_days' => 2,
            ],

            // Chubu Region (中部地方) - Nagoya and central Japan
            [
                'province' => 'Aichi',
                'city' => null,
                'zone_name' => 'Chubu Region',
                'base_fee' => 650.00,
                'delivery_days' => 2,
            ],
            [
                'province' => 'Aichi',
                'city' => 'Nagoya',
                'zone_name' => 'Major City',
                'base_fee' => 600.00,
                'delivery_days' => 2,
            ],
            [
                'province' => 'Shizuoka',
                'city' => null,
                'zone_name' => 'Chubu Region',
                'base_fee' => 700.00,
                'delivery_days' => 3,
            ],
            [
                'province' => 'Gifu',
                'city' => null,
                'zone_name' => 'Chubu Region',
                'base_fee' => 750.00,
                'delivery_days' => 3,
            ],

            // Tohoku Region (東北地方) - Northern Honshu
            [
                'province' => 'Miyagi',
                'city' => null,
                'zone_name' => 'Tohoku Region',
                'base_fee' => 800.00,
                'delivery_days' => 3,
            ],
            [
                'province' => 'Miyagi',
                'city' => 'Sendai',
                'zone_name' => 'Regional Hub',
                'base_fee' => 750.00,
                'delivery_days' => 3,
            ],
            [
                'province' => 'Fukushima',
                'city' => null,
                'zone_name' => 'Tohoku Region',
                'base_fee' => 850.00,
                'delivery_days' => 4,
            ],
            [
                'province' => 'Aomori',
                'city' => null,
                'zone_name' => 'Northern Japan',
                'base_fee' => 950.00,
                'delivery_days' => 4,
            ],

            // Hokkaido (北海道) - Northernmost island
            [
                'province' => 'Hokkaido',
                'city' => null,
                'zone_name' => 'Hokkaido Island',
                'base_fee' => 1000.00,
                'delivery_days' => 4,
            ],
            [
                'province' => 'Hokkaido',
                'city' => 'Sapporo',
                'zone_name' => 'Major City',
                'base_fee' => 900.00,
                'delivery_days' => 3,
            ],
            [
                'province' => 'Hokkaido',
                'city' => 'Hakodate',
                'zone_name' => 'Southern Hokkaido',
                'base_fee' => 950.00,
                'delivery_days' => 4,
            ],

            // Kyushu Region (九州地方) - Southern island
            [
                'province' => 'Fukuoka',
                'city' => null,
                'zone_name' => 'Kyushu Region',
                'base_fee' => 850.00,
                'delivery_days' => 3,
            ],
            [
                'province' => 'Fukuoka',
                'city' => 'Fukuoka City',
                'zone_name' => 'Regional Hub',
                'base_fee' => 800.00,
                'delivery_days' => 3,
            ],
            [
                'province' => 'Kumamoto',
                'city' => null,
                'zone_name' => 'Kyushu Region',
                'base_fee' => 900.00,
                'delivery_days' => 4,
            ],
            [
                'province' => 'Kagoshima',
                'city' => null,
                'zone_name' => 'Southern Kyushu',
                'base_fee' => 950.00,
                'delivery_days' => 4,
            ],

            // Shikoku Region (四国地方) - Smallest main island
            [
                'province' => 'Kagawa',
                'city' => null,
                'zone_name' => 'Shikoku Region',
                'base_fee' => 750.00,
                'delivery_days' => 3,
            ],
            [
                'province' => 'Ehime',
                'city' => null,
                'zone_name' => 'Shikoku Region',
                'base_fee' => 780.00,
                'delivery_days' => 3,
            ],

            // Chugoku Region (中国地方) - Western Honshu
            [
                'province' => 'Hiroshima',
                'city' => null,
                'zone_name' => 'Chugoku Region',
                'base_fee' => 700.00,
                'delivery_days' => 3,
            ],
            [
                'province' => 'Hiroshima',
                'city' => 'Hiroshima City',
                'zone_name' => 'Major City',
                'base_fee' => 650.00,
                'delivery_days' => 2,
            ],
            [
                'province' => 'Okayama',
                'city' => null,
                'zone_name' => 'Chugoku Region',
                'base_fee' => 720.00,
                'delivery_days' => 3,
            ],

            // Okinawa (沖縄県) - Southernmost prefecture
            [
                'province' => 'Okinawa',
                'city' => null,
                'zone_name' => 'Remote Islands',
                'base_fee' => 1200.00,
                'delivery_days' => 5,
            ],
            [
                'province' => 'Okinawa',
                'city' => 'Naha',
                'zone_name' => 'Main City',
                'base_fee' => 1100.00,
                'delivery_days' => 5,
            ],

            // Additional major cities and special zones
            [
                'province' => 'Gunma',
                'city' => null,
                'zone_name' => 'Mountain Region',
                'base_fee' => 650.00,
                'delivery_days' => 2,
            ],
            [
                'province' => 'Tochigi',
                'city' => null,
                'zone_name' => 'Kanto Extended',
                'base_fee' => 620.00,
                'delivery_days' => 2,
            ],
            [
                'province' => 'Ibaraki',
                'city' => null,
                'zone_name' => 'Kanto Extended',
                'base_fee' => 580.00,
                'delivery_days' => 2,
            ],
            [
                'province' => 'Nara',
                'city' => null,
                'zone_name' => 'Historic Region',
                'base_fee' => 680.00,
                'delivery_days' => 3,
            ],
            [
                'province' => 'Wakayama',
                'city' => null,
                'zone_name' => 'Kii Peninsula',
                'base_fee' => 720.00,
                'delivery_days' => 3,
            ],
            [
                'province' => 'Mie',
                'city' => null,
                'zone_name' => 'Central Japan',
                'base_fee' => 700.00,
                'delivery_days' => 3,
            ],
        ];

        foreach ($shippingData as $data) {
            ShippingRate::updateOrCreate(
                [
                    'province' => $data['province'],
                    'city' => $data['city'],
                ],
                $data
            );
        }

        $this->command->info('Shipping rates seeded successfully! Total: ' . count($shippingData) . ' records.');
    }
}
