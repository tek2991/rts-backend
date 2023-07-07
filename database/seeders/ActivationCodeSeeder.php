<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivationCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $randomCode = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 6);
            $randomDuration = random_int(30, 90);
            $randomPrice = random_int(100, 500);

            $data[] = [
                'code' => $randomCode,
                'duration_in_days' => $randomDuration,
                'price' => $randomPrice,
                'expires_at' => now()->addDays(30),
            ];
        }

        \App\Models\ActivationCode::insert($data);
    }
}
