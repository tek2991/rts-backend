<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Basic',
                'duration_in_days' => 30,
                'net_amount' => 100,
                'tax' => 18,
                'price' => 118,
                'is_active' => true,
            ],
            [
                'name' => 'Premium',
                'duration_in_days' => 90,
                'net_amount' => 200,
                'tax' => 36,
                'price' => 236,
                'is_active' => true,
            ],
            [
                'name' => 'Platinum',
                'duration_in_days' => 180,
                'net_amount' => 500,
                'tax' => 90,
                'price' => 590,
                'is_active' => true,
            ],
        ];
        \App\Models\Package::insert($data);
    }
}
