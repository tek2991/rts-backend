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
                'price' => 100,
                'is_active' => true,
            ],
            [
                'name' => 'Premium',
                'duration_in_days' => 90,
                'price' => 250,
                'is_active' => true,
            ],
            [
                'name' => 'Platinum',
                'duration_in_days' => 180,
                'price' => 500,
                'is_active' => true,
            ],
        ];
        \App\Models\Package::insert($data);
    }
}
