<?php

namespace App\Http\Controllers\ClientPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\CartOrder;
use App\Models\DocumentNotification;
use App\Models\Reservation;
use App\Models\SubscriptionPlan;
use App\Models\UpgradeLog;
use App\Models\User;
use App\Models\UserPlan;
use App\Rules\SubscriptionPlanToUpgradeBireysel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function getReservations() {
        $housingReservations = Reservation::with("user", "housing")
        ->where("user_id",auth()->user()->id)
        ->get();

        return view('client.client-panel.profile.reservations', compact('housingReservations'));
    }
    public function cartOrders()
    {
        $cartOrders = CartOrder::where('user_id', auth()->user()->id)->with("invoice")->orderBy("id", "desc")->get();
        if (Auth::user()->type == "2") {
            return view('institutional.orders.get', compact('cartOrders'));

        } else {
            return view('client.client-panel.profile.orders', compact('cartOrders'));

        }
    }



    public function verify()
    {
        return view('client.client-panel.home.verification');
    }

    public function verifyAccount(Request $request)
    {
        $request->validate(
            [
                'kimlik_belgesi' => 'required|image|mimes:jpg,jpeg,png',
            ]
        );

        $array = [];

        $file = $request->kimlik_belgesi->store('individual_identity_documents');
        $array = array_merge($array, ['identity_document' => $file]);

        auth()->user()->update($array);

        DocumentNotification::create([
            'user_id' => auth()->user()->parent_id ?? auth()->user()->id,
            'text' => 'Hesap onayı için yeni bir belge gönderildi. Kullanıcı: ' . auth()->user()->email,
            'item_id' => auth()->user()->parent_id ?? auth()->user()->id,
            'link' => route('admin.user.show-corporate-account', ['user' => auth()->user()->parent_id ?? auth()->user()->id]),
            'owner_id' => 4,
            'is_visible' => true,
        ]);

        return redirect()->back();
    }

    public function getIdentityDocument()
    {
        $user = auth()->user();
        $identity_document = $user->identity_document;

        if (is_null($identity_document)) {
            die('Belge yok.');
        }

        $file = file_get_contents(storage_path("/app/{$identity_document}"));
        preg_match('@\.(\w+)$@', $identity_document, $match);
        $extension = $match[1] ?? 'png';

        header('Content-Type: image/' . $extension);
        echo $file;
    }

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
        $before = UserPlan::where('user_id', auth()->user()->id)->where("status", "1")->first();
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
