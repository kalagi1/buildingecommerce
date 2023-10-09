<?php

namespace App\Http\Controllers\ClientPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\SubscriptionPlan;
use App\Models\UpgradeLog;
use App\Models\User;
use App\Models\UserPlan;
use App\Rules\SubscriptionPlanToUpgradeBireysel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function upgrade()
    {
        $plans = SubscriptionPlan::where('plan_type', 'Bireysel')->get();
        $current = UserPlan::with("subscriptionPlan")->where('user_id', auth()->user()->id)->first() ?? false;
        return view('client.client-panel.profile.upgrade', compact('plans', 'current'));
    }

    public function upgradeProfile(Request $request, $id)
    {
        $request->validate(['id' => $id],
            [
                'id' =>
                [
                    'required',
                    new SubscriptionPlanToUpgradeBireysel(),
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
            $before->housing_limit = 0;
        }

        $data =
            ['subscription_plan_id' => $plan->id,
            'housing_limit' => $before->housing_limit + $plan->housing_limit,
            'user_id' => auth()->user()->id,
            'subscription_plan_id' => $id,
            'project_limit' => 0,
            'user_limit' => 0,
        ];

        DB::beginTransaction();
        UpgradeLog::create(
            [
                'user_id' => auth()->user()->id,
                'plan_id' => $plan->id,
            ]
        );
        UserPlan::updateOrCreate(['user_id' => auth()->user()->id], $data);
        DB::commit();

        return redirect()->back()->with('success', 'Abonelik Planı Güncellendi.');
    }

    public function edit()
    {
        $user = auth()->user();
        return view('client.client-panel.profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = User::where("id", auth()->user()->id)->first();
        $user->update($request->all());
        return redirect()->route('client.profile.edit')->with('success', 'Profiliniz başarıyla güncellendi.');
    }
}
