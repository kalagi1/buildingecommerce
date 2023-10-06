<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\City;
use App\Models\County;
use App\Models\District;
use App\Models\Neighborhood;
use App\Models\SubscriptionPlan;
use App\Models\TaxOffice;
use App\Models\Town;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $cities = City::all();
        $towns = Town::all();
        $counties = County::all();
        $districts = District::all();
        $neighborhoods = Neighborhood::all();
        $subscriptionPlans = SubscriptionPlan::all();
        $user = User::where("id", Auth::user()->id)->first();
        $taxOffices = TaxOffice::all();
        return view('institutional.profile.edit', compact('user', "towns", "neighborhoods", "districts", 'taxOffices', 'cities', 'subscriptionPlans', 'counties'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = User::where("id", Auth::user()->id)->first();

        // Vergi Dairesi İli'nin şehir kimliğini alın
        $city = City::where("title", $request->input("taxOfficeCity"))->first();
        $taxOfficeCityId = $city ? $city->id : null;
        $data = $request->all();

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageFileName = 'profile_image_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_images', $imageFileName, 'public');
            $data['profile_image'] = $imageFileName; // Vergi Dairesi İli güncellendi
        }

        if ($request->input("account_type") == "1") {
            $accountType = "Şahıs Şirketi";
        } else {
            $accountType = "Limited veya Anonim Şirketi";
        }

        $data['taxOfficeCity'] = $taxOfficeCityId; // Vergi Dairesi İli güncellendi
        $data['account_type'] = $accountType; // Vergi Dairesi İli güncellendi

        // Kullanıcının bilgilerini güncelle
        $user->update($data);

        return redirect()->route('institutional.profile.edit')->with('success', 'Profiliniz başarıyla güncellendi.');
    }

}
