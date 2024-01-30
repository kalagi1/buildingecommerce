<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\BankAccount;
use App\Models\City;
use App\Models\County;
use App\Models\District;
use App\Models\EmailTemplate;
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
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function upgrade()
    {
        $bankAccounts = BankAccount::all();
        $user = User::where("id", auth()->user()->parent_id ?? auth()->user()->id)->first();
        $plans = SubscriptionPlan::where('plan_type', $user->corporate_type)->orderBy("price", "asc")->get();
        $current = UserPlan::with("subscriptionPlan")->where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->first();
        return view('institutional.profile.upgrade', compact('plans', 'current', 'bankAccounts'));
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
        $before = UserPlan::where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->where("status", "1")->first();
        $user = User::where('id', auth()->user()->parent_id ?? auth()->user()->id)->first();
        $user->update([
            'subscription_plan_id' => $plan->id,
        ]);

        $childrens = User::where("parent_id", auth()->user()->parent_id ?? auth()->user()->id)->get();

        if ($childrens) {
            foreach ($childrens as $key => $children) {
                $children->update([
                    "subscription_plan_id" => $plan->id,
                ]);
            }
        }

        switch ($user->corporate_type) {
            case 'Emlakçı':
                $data =
                    [
                    'subscription_plan_id' => $plan->id,
                    'user_limit' => $plan->user_limit,
                    'housing_limit' => $plan->housing_limit,
                    'key' => $request->input("key"),
                    "status" => 0,
                ];
                break;

            case 'Banka':
            case 'İnşaat':
                $data =
                    [
                    'subscription_plan_id' => $plan->id,
                    'user_limit' => $plan->user_limit,
                    'project_limit' => $plan->project_limit,
                    'housing_limit' => $plan->housing_limit,
                    'key' => $request->input("key"),
                    "status" => 0,

                ];
                break;

            default:
                return redirect()->back();
                break;
        }

        $emailTemplate = EmailTemplate::where('slug', "buy-package")->first();
        $emailSellTemplate = EmailTemplate::where('slug', "sell-package")->first();

        if (!$emailTemplate || !$emailSellTemplate) {
            return response()->json([
                'message' => 'Email template not found.',
                'status' => 203,
                'success' => true,
            ], 203);
        }

        $content = $emailTemplate->body;

        $variables = [
            'username' => $user->name,
            'packageName' => $plan->name,
            'companyName' => "Emlak Sepette",
            "email" => $user->email,
            "token" => $user->email_verification_token,
        ];

        foreach ($variables as $key => $value) {
            $content = str_replace("{{" . $key . "}}", $value, $content);
        }

        Mail::to($user->email)->send(new CustomMail($emailTemplate->subject, $content));

        $contentSell = $emailSellTemplate->body;

        $sellVariables = [
            'username' => $user->name,
            'packageName' => $plan->name,
            'companyName' => "Emlak Sepette",
            "email" => $user->email,
            "token" => $user->email_verification_token,
        ];

        foreach ($sellVariables as $key => $value) {
            $contentSell = str_replace("{{" . $key . "}}", $value, $contentSell);
        }

        $admins = User::where("type", "3")->get();
        foreach ($admins as $key => $value) {
            Mail::to($value->email)->send(new CustomMail($emailSellTemplate->subject, $contentSell));
        }

        DB::beginTransaction();
        UpgradeLog::create(
            [
                'user_id' => auth()->user()->parent_id ?? auth()->user()->id,
                'plan_id' => $plan->id,
            ]
        );
        UserPlan::where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->update($data);

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

    public function update(Request $request)
    {
        $request->validate([
            "name" => "required",
            "mobile_phone" => "required",
            "iban" => "required",
            "banner_hex_code" => "required",
        ],[
            "name.required" => "İsim alanı zorunludur",
            "mobile_phone.required" => "Cep telefonu zorunludur",
            "iban.required" => "Iban alanı zorunludur",
            "banner_hex_code.required" => "Mağaza arka plan rengi alanı zorunludur",
        ]);

        $user = User::where("id", Auth::user()->id)->first();

        // Vergi Dairesi İli'nin şehir kimliğini alın
        $city = City::where("title", $request->input("taxOfficeCity"))->first();
        $taxOfficeCityId = $city ? $city->id : null;
        $year = $request->input("year");
        $bank_name = $request->input("bank_name");
        $phone = $request->input("phone");
        $longitude = $request->input("longitude");
        $latitude = $request->input("latitude");



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
        $data['year'] = $year; // Vergi Dairesi İli güncellendi
        $data['bank_name'] = $bank_name; // Vergi Dairesi İli güncellendi
        $data['phone'] = $phone;
        $data['longitude'] = $longitude;
        $data['latitude'] = $latitude;




        
        $user->update($data);

        return redirect()->back();
    }

    public function clubUpdate(Request $request)
    {

        if (Auth::user()->type == "1") {
            $request->validate(
                [
                    "idNumber" => "required",
                    "phone" => "required",
                    "bank_name" => "required",
                    "instagramusername" => "required",
                    "iban" => "required",
                    "check-d" => "required"
                ],
                [
                    "idNumber.required" => "TC Kimlik Numarası alanı zorunludur.",
                    "phone.required" => "Telefon Numarası alanı zorunludur.",
                    "bank_name.required" => "Banka Adı alanı zorunludur.",
                    "instagramusername.required" => "Instagram Kullanıcı Adı alanı zorunludur.",
                    "iban.required" => "IBAN alanı zorunludur.",
                    "check-d.required" => "Onay kutusu zorunludur."
                ]
            );
        }else{
            $request->validate(
                [
                    "phone" => "required",
                    "bank_name" => "required",
                    "instagramusername" => "required",
                    "iban" => "required",
                    "check-d" => "required"
                ],
                [
                    "phone.required" => "Telefon Numarası alanı zorunludur.",
                    "bank_name.required" => "Banka Adı alanı zorunludur.",
                    "instagramusername.required" => "Instagram Kullanıcı Adı alanı zorunludur.",
                    "iban.required" => "IBAN alanı zorunludur.",
                    "check-d.required" => "Onay kutusu zorunludur."
                ]
            );
        }
       
        

        $user = User::where("id", Auth::user()->id)->first();


        $data = $request->all();
        $data = $request->except('check-d');

        $data['has_club'] = "2"; 
        $user->update($data);

        return  view("institutional.home.has-club-status");
    }

}
