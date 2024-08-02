<?php

namespace App\Observers;

use App\Models\Housing;
use App\Models\ShareLink;
use Illuminate\Support\Facades\DB;

class HousingObserver
{
    /**
     * Handle the Housing "created" event.
     */
    public function created(Housing $housing): void
    {
        // Code for handling the created event
    }

    /**
     * Handle the Housing "updated" event.
     */
    public function updated(Housing $housing): void
    {
        // Check if the status was updated to 0
        if ( $housing->status == 0 || $housing->is_sold == 1) {
            // Remove entries from the share_links table where housing_id matches the current housing's id
            DB::table('share_links')->where('item_id', $housing->id)->where('item_type', 2)->delete();
        }
    }

    /**
     * Handle the Housing "deleted" event.
     */ 
    public function deleted(Housing $housing): void
    {
        // Remove entries from the share_links table where housing_id matches the current housing's id
        ShareLink::where('item_type', 2)->where('item_id', $housing->id)->delete();
    }

    /**
     * Handle the Housing "restored" event.
     */
    public function restored(Housing $housing): void
    {
        // Code for handling the restored event
    }

    /**
     * Handle the Housing "force deleted" event.
     */
    public function forceDeleted(Housing $housing): void
    {
        // Code for handling the force deleted event
    }
}
