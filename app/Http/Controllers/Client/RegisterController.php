<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\Chat;
use App\Models\City;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\Subscription;
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
            'name1' => [
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') == 1 && empty($value)) {
                        $fail('İsim alanı zorunludur.');
                    }
                },
            ],
            'name' => [
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') == 2 && empty($value)) {
                        $fail('İsim alanı zorunludur.');
                    }
                },
            ],
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'mobile_phone' =>  'required',
            'type' => 'required|in:1,2,21',
            'corporate-account-type' => 'required_if:type,2|in:Emlak Ofisi,İnşaat Ofisi,Banka,Turizm Amaçlı Kiralama',
            'store_name' => 'required_if:type,2',
            'check-a' => 'required_if:type,1',
            'check-d' => 'required_if:type,2',
            'check-b' => 'required',
            'check-c' => 'required',
            'county_id' => "required_if:type,2",
            'city_id' => "required_if:type,2",
            'neighborhood_id' => "required_if:type,2",
            'username' => "required_if:type,2",
            'taxOffice' => "required_if:type,2",
            "taxOfficeCity" => "required_if:type,2",
            'taxNumber' => "required_if:type,2",
            'idNumber' => "required_if:account_type,1",
        ];

        $msgs = [
            'email.required' => 'E-posta adresi alanı zorunludur.',
            'mobile_phone.required' => 'Cep telefonu zorunludur.',
            'check-a.required_if' => "Hesap açmak için Bireysel Hesap Sözleşmesini kabul etmeniz gerekmektedir.",
            'check-d.required_if' => "Hesap açmak için Kurumsal Hesap Sözleşmesini kabul etmeniz gerekmektedir.",
            'check-b.required' => 'Hesap açmak için Kvkk metinini okuyup onaylamanız gerekmektedir.',
            'check-c.required' => 'Hesap açmak için Gizlilik sözleşmesi ve aydınlatma metnini okuyup onaylamanız gerekmektedir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi başka bir kullanıcı tarafından kullanılıyor.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 6 karakter uzunluğunda olmalıdır.',
            'type.required' => 'Kullanıcı türü seçimi zorunludur.',
            'type.in' => 'Geçerli bir kullanıcı türü seçiniz.',
            'corporate-account-type.required_if' => 'Kurumsal hesap türü seçimi zorunludur.',
            'corporate-account-type.in' => 'Geçerli bir kurumsal hesap türü seçiniz.',
            'store_name.required_if' => 'Ticari Unvan zorunludur.',
            'county_id.required_if' => 'İlçe seçimi zorunludur.',
            'city_id.required_if' => 'Şehir seçimi zorunludur.',
            'neighborhood_id.required_if' => 'Mahalle seçimi zorunludur.',
            'username.required_if' => 'Kullanıcı adı zorunludur.',
            'taxOffice.required_if' => 'Vergi dairesi adı zorunludur.',
            'taxOfficeCity.required_if' => 'Vergi dairesi ili zorunludur.',
            'taxNumber.required_if' => 'Vergi numarası zorunludur.',
            'idNumber.required_if' => 'T.C. kimlik numarası zorunludur.',
            'subscription_plan_id.nullable' => 'Abonelik planı seçimi yapılmışsa geçerli bir abonelik planı seçiniz.',
        ];

        $city = City::where("title", $request->input("taxOfficeCity"))->first();

        if ($request->input("account_type") == "1") {
            $accountType = "Şahıs Şirketi";
        } else {
            $accountType = "Limited veya Anonim Şirketi";
        }

        // Form doğrulama işlemini gerçekleştirin
        $validatedData = $request->validate($rules, $msgs);
        // Yeni kullanıcıyı oluşturun
        $user = new User();
        $user->email = $request->input("email");
        $user->subscription_plan_id = $request->input("subscription_plan_id");

        $subscriptionPlan = SubscriptionPlan::where("id", $request->input("subscription_plan_id"))->first();

        $user->name = $request->input("name") ? $request->input("name") : $request->input("name1");
        $user->profile_image = "indir.png";
        $user->banner_hex_code = "black";
        $user->password = bcrypt($request->input("password"));
        $user->type = $request->input("type") ? $request->input("type") : 1;
        $user->iban = $request->input("iban");
        $user->county_id = $request->input("county_id");
        $user->city_id = $request->input("city_id");
        $user->phone = $request->input("phone");
        $user->mobile_phone = $request->input("mobile_phone");
        $user->neighborhood_id = $request->input("neighborhood_id");
        $user->username = $request->input("username");
        $user->account_type = $accountType;
        $user->taxOfficeCity = $city->id ?? 0;
        $user->taxOffice = $request->input("taxOffice");
        $user->taxNumber = $request->input("taxNumber");
        $user->idNumber = $request->input("idNumber");
        $user->status = 0;
        $user->email_verification_token = Str::random(40);
        $user->corporate_type = $request->input("corporate-account-type");
        $user->authority_licence = $request->input("authority_licence");
        $user->save();

        if ($request->input("type") == 2) {
            $maxOrder = User::where("type", 2)->max("order");
            $user->order = $maxOrder + 1;
            $user->save();
            UserPlan::create([
                "user_id" => $user->id,
                "subscription_plan_id" => null,
                "project_limit" => 0,
                "user_limit" => 0,
                "housing_limit" => 0,
            ]);
        } else {
            $user->update([
                "corporate_account_status" => 1,
            ]);
        }

          // "Tarafıma elektronik ileti gönderilmesini kabul ediyorum" kutusu işaretlenmişse
          if ($request->has('check-e')) {
            Subscription::create([
                'user_id' => $user->id,
            ]);
          }

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
            'username' => $user->name,
            'companyName' => "Emlak Sepette",
            "email" => $request->input("email"),
            "token" => $user->email_verification_token,
            "verificationLink" => URL::to("/verify-email/{$user->email_verification_token}"),
        ];

        foreach ($variables as $key => $value) {
            $content = str_replace("{{" . $key . "}}", $value, $content);
        }

        Chat::create([
            "user_id" => $user->id
        ]);


        try
        {
            Mail::to($request->input("email"))->send(new CustomMail($emailTemplate->subject, $content));
            session()->flash('success', 'Hesabınız oluşturuldu. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['status' => 'Onay e-postası gönderilemedi.']);
        }

        return redirect()->route('client.login');

    }
}
