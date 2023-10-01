<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\City;
use App\Models\EmailTemplate;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'type' => 'required|in:1,2',
        ];

        $city = City::where("title", $request->input("taxOfficeCity"))->first();

        if ($request->input("account_type") == "1") {
            $accountType = "Şahıs Şirketi";
        } else {
            $accountType = "Limited veya Anonim Şirketi";
        }

        // Form doğrulama işlemini gerçekleştirin
        $validatedData = $request->validate($rules);
        // Yeni kullanıcıyı oluşturun
        $user = new User();
        $user->email = $validatedData['email'];
        $user->subscription_plan_id = $request->input("subscription_plan_id");

        $subscriptionPlan = SubscriptionPlan::where("id", $request->input("subscription_plan_id"))->first();


        $user->name = $validatedData['name'];
        $user->password = bcrypt($validatedData['password']);
        $user->type = $validatedData['type'];
        $user->activity = $request->input("activity");
        $user->county_id = $request->input("county_id");
        $user->account_type = $accountType;
        $user->taxOfficeCity = $city->id;
        $user->taxOffice = $request->input("taxOffice");
        $user->taxNumber = $request->input("taxNumber");
        $user->idNumber = $request->input("idNumber");
        $user->status = 0;
        $user->email_verification_token = Str::random(40);
        $user->save();

        UserPlan::create([
            "user_id" => $user->id,
            "subscription_plan_id" => $subscriptionPlan->id,
            "project_limit" => $subscriptionPlan->project_limit,
            "user_limit" => $subscriptionPlan->user_limit,
            "housing_limit" => $subscriptionPlan->housing_limit,
        ]);
        $emailTemplate = EmailTemplate::where('slug', "account-verify")->first();

        if (!$emailTemplate) {
            return response()->json([
                'message' => 'Email template not found.',
                'status' => 203,
                'success' => true,
            ], 203);
        }

        $content = $emailTemplate->body;

        $variables = [
            'username' => $validatedData['name'],
            'companyName' => "Emlak Sepeti",
            "email" => $validatedData['email'],
            "token" => $user->email_verification_token,
            "verificationLink" => URL::to("/verify-email/{$user->email_verification_token}"),
        ];

        foreach ($variables as $key => $value) {
            $content = str_replace("{{" . $key . "}}", $value, $content);
        }

        try {
            Mail::to($request->input('email'))->send(new CustomMail($emailTemplate->subject, $content));
            session()->flash('success', 'Hesabınız oluşturuldu. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.');
            return redirect()->route('client.login');

        } catch (\Exception $e) {
            session()->flash('error', 'Hata');
            return redirect()->route('client.login');

        }

    }
}
