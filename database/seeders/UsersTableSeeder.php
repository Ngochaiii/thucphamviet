<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo admin user
        $admin = User::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '0594414099',
            'role' => 1,
            'first_name' => 'Admin',
            'last_name' => 'Thai Duong',
            'display_name' => 'Admin Thai Duong',
        ]);

        // Tạo customer mẫu
        $customer = User::create([
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'phone' => '0987654321',
            'role' => 0,
            'first_name' => 'Nguyen Van',
            'last_name' => 'A',
            'display_name' => 'Nguyen Van A',
        ]);
    }
}
