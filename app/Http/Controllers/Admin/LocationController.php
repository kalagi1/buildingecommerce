<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Models\Neighborhood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return view('admin.locations.index', compact('cities'));
    }

    public function getDistricts(Request $request)
    {
        $cityId = $request->input('city_id');
        $districts = District::where('ilce_sehirkey', $cityId)->get();
        return response()->json($districts);
    }

    public function getNeighborhoods(Request $request)
    {
        $districtId = $request->input('district_id');
        $neighborhoods = Neighborhood::where('mahalle_ilcekey', $districtId)->get();
        return response()->json($neighborhoods);
    }

    public function saveMetaDescriptions(Request $request)
    {
        // Get the raw meta_descriptions data from the request
        $metaDescriptions = $request->input('meta_descriptions', []);

        foreach ($metaDescriptions as $id => $data) {
            // Validate and update city meta description if provided
            if (isset($data['city']) && is_string($data['city']) && !empty($data['city'])) {
                $city = City::find($id);
                if ($city) {
                    $city->meta_description = $data['city'];
                    $city->save();
                } else {
                    Log::warning('City not found', ['cityId' => $id]);
                }
            }
            if (isset($data['district']) && is_string($data['district']) && !empty($data['district'])) {
                $district = District::where("ilce_key", $id)->first();

                if ($district) {
                    $district->meta_description = $data['district'];
                    $district->save();
                } else {
                    Log::warning('City not found', ['districtId' => $id]);
                }
            }

            // Validate and update neighborhood meta descriptions if provided
            if (isset($data['neighborhoods']) && is_array($data['neighborhoods'])) {
                foreach ($data['neighborhoods'] as $neighborhoodId => $description) {
                    if (is_string($description) && !empty($description)) {
                        $neighborhood = Neighborhood::where("mahalle_id", $neighborhoodId)->first();
                        if ($neighborhood) {
                            $neighborhood->meta_description = $description;
                            $neighborhood->save();
                        } else {
                            Log::warning('Neighborhood not found', ['neighborhoodId' => $neighborhoodId]);
                        }
                    }
                }
            } else if (isset($data['neighborhoods'])) {
                Log::error('Invalid neighborhoods data format', ['neighborhoods' => $data['neighborhoods']]);
            }
        }

        return response()->json(['success' => true]);
    }
}
