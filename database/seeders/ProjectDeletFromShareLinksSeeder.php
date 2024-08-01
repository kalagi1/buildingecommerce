<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectDeletFromShareLinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the IDs from the projects table
        $projectIds = DB::table('projects')->pluck('id')->whereNotNull('deleted_at')->toArray();

        // Delete from share_links where item_type is 1 and item_id is not in the projects table
        DB::table('share_links')
            ->where('item_type', 1)
            ->whereNotIn('item_id', $projectIds)
            ->delete();
    }
}
