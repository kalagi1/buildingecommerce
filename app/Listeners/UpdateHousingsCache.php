<?php

namespace App\Listeners;

use App\Events\HousingCreated;
use App\Models\Housing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class UpdateHousingsCache
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(HousingCreated $event)
    {
        Cache::forget('last_four_housings');

        $secondhandHousings = Housing::where('status', 1)
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();
    
        Cache::forever('last_four_housings', $secondhandHousings);
    }
    
}
