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
use App\Models\UpgradeLog;
use App\Models\User;
use App\Models\UserPlan;
use App\Rules\SubscriptionPlanToUpgrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function upgrade()
    {
        $plans = SubscriptionPlan::where('plan_type', auth()->user()->corporate_type)->get();
        $current = UserPlan::with("subscriptionPlan")->where('user_id', auth()->user()->id)->first() ?? false;
        return view('institutional.profile.upgrade', compact('plans', 'current'));
    }

    public function upgradeProfile(Request $request, $id)
    {
        $request->validate(['id' => $id],
            [
                'id' =>
                [
                    'required',
                    new SubscriptionPlanToUpgrade(),
                ],
            ]
        );

        $plan = SubscriptionPlan::find($id);
        $before = UserPlan::where('user_id', auth()->user()->id)->first();
        $user = User::where('id', auth()->user()->id)->first();
        $user->update([
            'subscription_plan_id' => $plan->id,
        ]);

        if (!$before) {
            $before = new \stdClass();
            $before->user_limit = 0;
            $before->housing_limit = 0;
            $before->project_limit = 0;
        }

        switch (auth()->user()->corporate_type) {
            case 'Emlakçı':
                $data =
                    [
                    'subscription_plan_id' => $plan->id,
                    'user_limit' => $before->user_limit + $plan->user_limit,
                    'housing_limit' => $before->housing_limit + $plan->housing_limit,
                ];
                break;

            case 'Banka':
            case 'İnşaat':
                $data =
                    [
                    'subscription_plan_id' => $plan->id,
                    'user_limit' => $before->user_limit + $plan->user_limit,
                    'project_limit' => $before->project_limit + $plan->project_limit,
                    'housing_limit' => $before->housing_limit + $plan->housing_limit,
                ];
                break;

            default:
                return redirect()->back();
                break;
        }

        DB::beginTransaction();
        UpgradeLog::create(
            [
                'user_id' => auth()->user()->id,
                'plan_id' => $plan->id,
            ]
        );
        UserPlan::where('user_id', auth()->user()->id)->update($data);
        DB::commit();

        return redirect()->back()->with('success', 'Plan başarıyla eklendi.');
    }

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
