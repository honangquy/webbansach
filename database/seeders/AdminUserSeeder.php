<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@webbansach.com',
            'password' => \Hash::make('password'),
            'role' => 'admin',
            'phone' => '0123456789',
            'address' => 'Hà Nội, Việt Nam'
        ]);

        // Tạo user customer mẫu
        \App\Models\User::create([
            'name' => 'Khách hàng',
            'email' => 'customer@example.com',
            'password' => \Hash::make('password'),
            'role' => 'customer',
            'phone' => '0987654321',
            'address' => 'TP. Hồ Chí Minh, Việt Nam'
        ]);
    }
}
