<?php

namespace App\Observers;

use App\Models\Housing;
use Illuminate\Support\Facades\DB;

class HousingObserver
{
    /**
     * Handle the Housing "created" event.
     */
    public function created(Housing $housing): void
    {
        //
    }

    /**
     * Handle the Housing "updated" event.
     */
    public function updating(Housing $housing)
    {
        // Check if the status is being set to 0
        if ($housing->status == 0) {
            // Remove entries from the collections table where housing_id matches the current housing's id
            // DB::table('collections')->where('housing_id', $housing->id)->delete();
        }
    }

    /**
     * Handle the Housing "deleted" event.
     */
    public function deleted(Housing $housing): void
    {
        //
    }

    /**
     * Handle the Housing "restored" event.
     */
    public function restored(Housing $housing): void
    {
        //
    }

    /**
     * Handle the Housing "force deleted" event.
     */
    public function forceDeleted(Housing $housing): void
    {
        //
    }
}
