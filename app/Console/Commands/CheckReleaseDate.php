<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Housing; // Housing modelini import edin
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class CheckReleaseDate extends Command
{
    protected $signature = 'check:release-date';
    protected $description = 'Check housing release dates and send request if it matches today or if it is 3 months from today if no release date is set';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $housings = Housing::all();
        $today = Carbon::today()->toDateString();
        $threeMonthsLater = Carbon::today()->addMonths(3)->toDateString();

        foreach ($housings as $housing) {
            $housingData = json_decode($housing->housing_type_data, true);
            
            if (isset($housingData['release_date']) && $housingData['release_date'] == $today) {
                // Release date is today, send request
                $housing->update(['status' => 0]);
                Log::info('Request sent for housing ID: ' . $housing->id  . 'Housing status has been set to passive.');
            }
            //  elseif (!isset($housingData['release_date'])) {
            //     // No release date, set it to 3 months later and send request
            //     $housingData['release_date'] = $threeMonthsLater;
            //     $housing->housing_type_data = json_encode($housingData);
            //     $housing->save();

            //     // Schedule job for 3 months later (this part will be handled by scheduler)
            //     $housing->update(['status' => 0]);
            //     Log::info('Request sent for housing ID: ' . $housing->id . ' with new release date set to 3 months later.');
            // }
        }
    }
}
