<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\Chat;
use App\Models\City;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\SmsService;


class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $credentials = $request->only( 'email', 'password' );
        $user = User::where( 'email', $request->email )->first();
        if ( $user ) {

            if ( $user->status == 0 ) {
                $this->sendVerificationEmail( $user );
                return json_encode([
                    "status" => false,
                    "message" => 'Giriş Başarısız. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.'
                ]);
            } elseif ( $user->status == 5 ) {
                return json_encode([
                    "status" => false,
                    "message" => 'Bu kullanıcının hesabı geçici olarak askıya alınmıştır. Hesabınızın yeniden etkinleştirilmesi için lütfen yöneticinizle iletişime geçin.'
                ]);
            }elseif ($user->is_blocked == 1) {
                return json_encode([
                    "status" => false,
                    "message" => 'Bu kullanıcının hesabı geçici olarak askıya alınmıştır. Hesabınızın yeniden etkinleştirilmesi için lütfen yöneticinizle iletişime geçin.'
                ]);
            } elseif ( $user->status == 1 ) {
                if ( Auth::attempt( $credentials , $request->filled('remember')) ) {
                    $user = Auth::user();
                    $updateUser = User::where( 'id', Auth::user()->id )->first();
                    
                    if ( $user->type == 1 && !$user->last_login ) {
                        // Bireysel kullanıcı için ilk giriş hoş geldiniz mesajı
                        DocumentNotification::create( [
                            'user_id' => $user->id,
                            'text' => 'Sayın ' . $user->name . ', Emlak Sepette ailesine hoş geldiniz! İhtiyaçlarınıza uygun emlakları keşfetmek veya güvenli bir şekilde tatil rezervasyonu yapmak için sitemizi kullanabilirsiniz. İyi günler dileriz.',
                            'item_id' => $user->id,
                            'link' => route( 'index' ),
                            'owner_id' => $user->id,
                            'is_visible' => true,
                        ] );

                        // last_login alanını güncelle
                        $updateUser->update( [ 'last_login' => now() ] );
                    } elseif ( $user->type == 2 && !$user->last_login ) {
                        // Kurumsal kullanıcı için ilk giriş hoş geldiniz mesajı
                        DocumentNotification::create( [
                            'user_id' => $user->id,
                            'text' => 'Sayın ' . $user->name . ', Emlak Sepette ailesine hoş geldiniz! Kurumsal hesabınızla projeler veya emlaklarınızı satışa sunabilirsiniz. İhtiyaçlarınıza uygun işlemleri gerçekleştirmek için sitemizi kullanabilirsiniz. İyi çalışmalar dileriz.',
                            'item_id' => $user->id,
                            'link' => route( 'index' ),
                            'owner_id' => $user->id,
                            'is_visible' => true,
                        ] );

                        // last_login alanını güncelle
                        $updateUser->update( [ 'last_login' => now() ] );
                    } elseif ( $user->type != 3 && $user->type != 1 && $user->type != 2 &&  $user->type != 21 && !$user->last_login ) {
                        // Kurumsal alt kullanıcı için hoş geldiniz mesajı
                        DocumentNotification::create( [
                            'user_id' => $user->id,
                            'text' => 'Sayın ' . $user->name . ', Emlak Sepette ailesine hoş geldiniz! Kurumsal hesabınızın verdiği yetkilere göre işlemleri gerçekleştirebilirsiniz. İhtiyaçlarınıza uygun işlemleri gerçekleştirmek için sitemizi kullanabilirsiniz. İyi çalışmalar dileriz.',
                            'item_id' => $user->id,
                            'link' => route( 'index' ),
                            'owner_id' => $user->id,
                            'is_visible' => true,
                        ] );

                        // last_login alanını güncelle
                        $updateUser->update( [ 'last_login' => now() ] );
                    } elseif ( $user->type == 21 && !$user->last_login && $user->type != 1 && $user->type != 2 ) {
                        DocumentNotification::create( [
                            'user_id' => $user->id,
                            'text' => 'Merhaba ' . $user->name . '! Emlak Kulüp ailesine hoş geldiniz! Emlak Sepette projeleri ve konutları koleksiyonunuza ekleyip paylaşarak kazanç elde edebilirsiniz. Sadece sizinle paylaşılan linkler üzerinden yapılan alışverişlerden komisyon alacaksınız. İyi kazançlar dileriz!',
                            'item_id' => $user->id,
                            'link' => route( 'index' ),
                            'owner_id' => $user->id,
                            'is_visible' => true,
                        ] );

                    }
                    $cart = session( 'cart', [] );
                    if ( count( $cart ) != 0 ) {
                        session( [ 'cart' => $cart ] );
                    }
                    
                    $accessToken = auth()->user()->createToken('authToken')->accessToken;

                    return response()->json([
                        "status" => 200,
                        'success' => true,
                        'id' => $user->id,
                        'name' => $user->name,
                        'role' => $user->role->name,
                        'slug' => $user->role->slug,
                        "buyerStatus" => $user->status,
                        'email' => $user->email,
                        'access_token' => $accessToken,
                        "rolePermissions" => $user->role->rolePermissions,
                        "works" => $user->works,
                        'token_type' => 'Bearer'
                    ]);
                }else{
                    return json_encode([
                        "status" => false,
                        "message" => "Kullanıcı bilgileri hatalı"
                    ]);
                }

            }
        } else {
            return json_encode([
                "status" => false,
                "message" => 'Giriş Başarısız. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.'
            ]);

        }
    }

    public function register(Request $request){
        $rules = [
            'name1' => [
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') == 1 && empty($value)) {
                        return 'required';
                    }
                },
            ],
            'name' => [
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') == 2 && empty($value)) {
                        return 'required';
                    }
                },
            ],
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'mobile_phone' =>  'required',
            'type' => 'required|in:1,2,21',
            'corporate-account-type' => 'required_if:type,2|in:Emlak Ofisi,İnşaat Ofisi,Banka,Turizm Amaçlı Kiralama',
            'activity' => 'required_if:type,2',
            'iban' => 'required_if:type,2',
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
            'activity.required_if' => 'Kurumsal hesap aktivitesi seçimi zorunludur.',
            'iban.required_if' => 'Iban zorunludur.',
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

        $validator = Validator::make($request->all(),$rules,$msgs);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
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
        // $user->activity = $request->input("activity");
        // $user->iban = $request->input("iban");
        $user->county_id = $request->input("county_id");
        $user->city_id = $request->input("city_id");
        $user->phone = $request->input("phone");
        $user->mobile_phone = $request->input("mobile_phone");
        $user->phone = $request->input("phone");
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
            return json_encode([
                "status" => true,
                "message" => 'Hesabınız oluşturuldu. Hesabınızı etkinleştirmek için lütfen e-posta adresinize gönderilen doğrulama bağlantısını tıklayarak e-postanızı onaylayın.'
            ]);

        } catch (\Exception $e) {
            return json_encode([
                "status" => false,
                "message" => 'Onay e-postası gönderilemedi.'
            ]);
        }

        return json_encode([
            "status" => true
        ]);
    }

    public function generateVerificationCode(){
        
        $verificationCode = mt_rand(100000, 999999);// Rastgele 6 haneli bir doğrulama kodu oluşturuluyor
        
        $user = auth()->user(); // Mevcut kullanıcıyı alıyoruz

        if ($user) {
            $user->phone_verification_code = $verificationCode; // Kullanıcıya doğrulama kodunu atıyoruz
            $user->phone_verification_status = 0; // Doğrulama durumunu 0 olarak ayarlıyoruz
            $user->save();// Kullanıcıyı kaydediyoruz
            if($user->phone_verification_code) {
                $this->sendSMS($user);
            }
           
            return response()->json([
                'success' => true
            ]);
        } 
    }//End

    private function sendSMS($user)
    {
        // Kullanıcının telefon numarasını al
        $userPhoneNumber = $user->mobile_phone;

        // Kullanıcının adını ve soyadını al
        $name = $user->name;

        // SMS metni oluştur
        $message = "$user->phone_verification_code nolu onay kodu ile hesabınızı güvenli bir şekilde doğrulayabilirsiniz.";
      
        // SMS gönderme işlemi
        $smsService = new SmsService();
        $source_addr = 'Emlkspette';

        $smsService->sendSms($source_addr, $message, $userPhoneNumber);
    }

    public function verifyPhoneNumber(Request $request)
    {
        $user = auth()->user(); // Mevcut kullanıcıyı alıyoruz

        if ($user) {
            $verificationCode = implode('', $request->input('code')); // Kodları birleştir

            if ($verificationCode == $user->phone_verification_code) {
                $user->phone_verification_status = 1; // Doğrulama durumunu 1 olarak ayarlıyoruz
                $user->save(); // Kullanıcıyı kaydediyoruz
                return response()->json([
                    'success' => true
                ]);
            } else {
                return response()->json()->withErrors(['error' => 'Doğrulama Kodu Eşleşmedi']);
            }

        }
    }   
}
