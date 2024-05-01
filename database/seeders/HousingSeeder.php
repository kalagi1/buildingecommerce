<?php

namespace Database\Seeders;

use App\Models\Housing;
use App\Models\Institution;
use App\Models\Rate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HousingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $housings = Housing::all();

        foreach ($housings as $key => $value) {
            $institutions = Institution::all();

            foreach ($institutions as $key => $institution) {
                if ($institution->name != "Diğer") {
                    Rate::create([
                        'institution_id' => $institution->id,
                        'housing_id' => $value->id,
                        'default_deposit_rate' => 0.90,
                        'sales_rate_club' => 0.50,
                    ]);
                } else {
                    Rate::create([
                        'institution_id' => $institution->id,
                        'housing_id' => $value->id,
                        'default_deposit_rate' => 0.90,
                        'sales_rate_club' => 0.25,
                    ]);
                }
            }
        }
    }
}
