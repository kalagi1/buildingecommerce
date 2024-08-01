<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HousingDeletFromShareLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // Get the IDs from the housings table
        $housingIds = DB::table('housings')->pluck('id')->whereNotNull('deleted_at')->toArray();

        // Delete from share_links where item_type is 2 and item_id is not in the housings table
        DB::table('share_links')
            ->where('item_type', 2)
            ->whereNotIn('item_id', $housingIds)
            ->delete();
    }
}
