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
        // Get the IDs from the projects table where `deleted_at` is not null
        $deletedProjectIds = DB::table('projects')
            ->whereNotNull('deleted_at')
            ->pluck('id')
            ->toArray();

        // Get the IDs from the projects table where `status` is 0
        $statusZeroProjectIds = DB::table('projects')
            ->where('status', 0)
            ->pluck('id')
            ->toArray();

        // Merge the two arrays to create a combined list of IDs
        $projectIds = array_merge($deletedProjectIds, $statusZeroProjectIds);

        // Delete from share_links where `item_type` is 1 and `item_id` is in the combined list of project IDs
        DB::table('share_links')
            ->where('item_type', 1)
            ->whereIn('item_id', $projectIds)
            ->delete();
    }
}
