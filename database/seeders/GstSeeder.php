<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gsts = [
            1 => [
                'name' => 'CGST',
                'rate' => 9,
            ],

            2 => [
                'name' => 'SGST',
                'rate' => 9,
            ],
        ];

        foreach ($gsts as $gst) {
            \App\Models\Gst::create($gst);
        }
    }
}
