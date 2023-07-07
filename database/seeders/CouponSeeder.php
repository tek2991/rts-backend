<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $randomCode = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 6);
            $randomPromoterName = ['John Doe', 'Jane Doe', 'John Smith', 'Jane Smith'][random_int(0, 3)];
            $randomMaxUse = random_int(2, 10);
            $randomDiscount = random_int(10, 50);

            $data[] = [
                'code' => $randomCode,
                'promoter_name' => $randomPromoterName,
                'max_use' => $randomMaxUse,
                'discount_percentage' => $randomDiscount,
            ];
        }

        \App\Models\Coupon::insert($data);
    }
}
