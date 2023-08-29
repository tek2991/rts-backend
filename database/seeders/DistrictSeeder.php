<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = \App\Models\StateModel::defaultValues();

        foreach ($states as $state) {
            $stateModel = \App\Models\StateModel::firstOrCreate([
                'name' => $state
            ]);

            $districts = \App\Models\District::defaultValues()[$state];

            foreach ($districts as $district) {
                \App\Models\District::firstOrCreate([
                    'name' => $district,
                    'state_id' => $stateModel->id
                ]);
            }
        }
    }
}
