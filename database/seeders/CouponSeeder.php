<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10,
                'minimum_order_amount' => 100000,
                'usage_limit' => 100,
                'usage_limit_per_user' => 1,
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(30),
                'description' => 'Mã giảm giá 10% cho khách hàng mới, đơn hàng từ 100,000đ',
                'is_active' => true,
            ],
            [
                'code' => 'SAVE50K',
                'type' => 'fixed',
                'value' => 50000,
                'minimum_order_amount' => 300000,
                'usage_limit' => 50,
                'usage_limit_per_user' => 2,
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(15),
                'description' => 'Giảm 50,000đ cho đơn hàng từ 300,000đ',
                'is_active' => true,
            ],
            [
                'code' => 'BIGsale20',
                'type' => 'percentage',
                'value' => 20,
                'minimum_order_amount' => 500000,
                'usage_limit' => 25,
                'usage_limit_per_user' => 1,
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(7),
                'description' => 'Mã giảm giá 20% cho đơn hàng từ 500,000đ - Chương trình đặc biệt',
                'is_active' => true,
            ],
            [
                'code' => 'FREESHIP',
                'type' => 'fixed',
                'value' => 30000,
                'minimum_order_amount' => 200000,
                'usage_limit' => null, // Không giới hạn
                'usage_limit_per_user' => 3,
                'starts_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addDays(60),
                'description' => 'Miễn phí vận chuyển (giảm 30,000đ) cho đơn hàng từ 200,000đ',
                'is_active' => true,
            ],
            [
                'code' => 'EXPIRED',
                'type' => 'percentage',
                'value' => 15,
                'minimum_order_amount' => null,
                'usage_limit' => 10,
                'usage_limit_per_user' => 1,
                'starts_at' => Carbon::now()->subDays(10),
                'expires_at' => Carbon::now()->subDays(1), // Đã hết hạn
                'description' => 'Mã giảm giá đã hết hạn - để test',
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $couponData) {
            Coupon::updateOrCreate(
                ['code' => $couponData['code']],
                $couponData
            );
        }
    }
}
