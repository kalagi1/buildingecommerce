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
                $defaultDepositRate = 0.90;
                $institutionalRateClub = 0.45;
                $clientRateClub = 0.25;
                $clientDepositRate = 0.70;
            
                $isOpenSharing1Set = isset($postData['open_sharing1']);
            
                $sellTypeInstitutionalRate = $value->owner_id && $institution->name !== "Diğer" ? 0.80 : null;
                $sellTypeClientRate = ! $value->owner_id && $institution->name === "Diğer" ? 0.70 : null;
            
                $sellTypeInstitutionalClub =  $value->owner_id && $institution->name !== "Diğer" ? 0.40 : null;
                $sellTypeClientClub = ! $value->owner_id && $institution->name === "Diğer" ? 0.25 : null;
            
                $defaultDepositRateToUse = $institution->name !== "Diğer" ? ($sellTypeInstitutionalRate ?? $defaultDepositRate) : ($sellTypeClientRate ?? $clientDepositRate);
                $salesRateClubToUse = $institution->name !== "Diğer" ? ($sellTypeInstitutionalClub ?? $institutionalRateClub) : ($sellTypeClientClub ?? $clientRateClub);
            
                // Check if Rate record already exists for this institution and project
                $existingRate = Rate::where('institution_id', $institution->id)
                                    ->where('housing_id', $value->id)
                                    ->first();
            
                if (!$existingRate) {
                    Rate::create([
                        'institution_id' => $institution->id,
                        'housing_id' => $value->id,
                        'default_deposit_rate' => $defaultDepositRateToUse,
                        'sales_rate_club' => $salesRateClubToUse,
                    ]);
                }
            }
        }
    }
}
