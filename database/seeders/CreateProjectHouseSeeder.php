<?php

namespace Database\Seeders;

use App\Models\ProjectHousing;
use Illuminate\Database\Seeder;

class CreateProjectHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $houses = ProjectHousing::where("project_id", "112")->where("room_order", "1")->get();
        if ($houses->count() > 0) {
            for ($i = 1; $i <= 11; $i++) {
                foreach ($houses as $house) {
                    $newHouse = new ProjectHousing();
                    $newHouse->project_id = $house->project_id;
                    $newHouse->room_order = $house->room_order + $i;
                    $newHouse->key = $house->key;
                    $newHouse->value = $house->value;
                    $newHouse->name = $house->name;
                    $newHouse->save();
                }
            }
        }
    }
}
