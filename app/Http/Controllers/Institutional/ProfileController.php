<?php

namespace App\Http\Controllers\Institutional;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\BankAccount;
use App\Models\City;
use App\Models\County;
use App\Models\District;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\Neighborhood;
use App\Models\SubscriptionPlan;
use App\Models\TaxOffice;
use App\Models\Town;
use App\Models\UpgradeLog;
use App\Models\User;
use App\Models\UserPlan;
use App\Rules\SubscriptionPlanToUpgrade;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function upgrade()
    {
        $bankAccounts = BankAccount::all();
        $user = User::where("id", auth()->user()->parent_id ?? auth()->user()->id)->first();
        $plans = SubscriptionPlan::where('plan_type', $user->corporate_type)->orderBy("price", "asc")->get();
        $current = UserPlan::with("subscriptionPlan")->where('user_id', auth()->user()->parent_id ?? auth()->user()->id)->first();
        return view('client.panel.profile.upgrade', compact('plans', 'current', 'bankAccounts'));
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
            case 'Emlak Ofisi':
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
            case 'İnşaat Ofisi':
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
        return view('client.panel.profile.edit', compact('user', "towns", "neighborhoods", "districts", 'taxOffices', 'cities', 'subscriptionPlans', 'counties'));
    }

    public function companyProfileUpdate(Request $request)
    {
    
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'iban' => 'required|string|max:34|iban_tr', // IBAN format validation can be added
            'web_site' => 'url|max:255',
            'phone_number' => 'required|string|max:8', // Phone number format validation can be added
            'sector_year' => 'required|integer',
        ]);


        // Update the user's location
        $user->name = $request->input('name');
        $user->iban = $request->input('iban');
        $user->website = $request->input('web_site');
        $user->phone = $request->input('phone_number');
        $user->year = $request->input('sector_year');
        $user->taxOffice = $request->input('area_code');
        
        // Save the updated user
        $user->save();

        return redirect()->back()->with('success', 'Firma bilgileri başarıyla güncellendi.');
    }

    public function locationUpdate(Request $request)
    {
        $user = Auth::user();

        // Validate the request data
        $request->validate([
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        // Update the user's location
        $user->longitude = $request->input('longitude');
        $user->latitude = $request->input('latitude');
        
        // Save the updated user
        $user->save();

        return redirect()->back()->with('success', 'Firma konumu başarıyla güncellendi.');
    }


    public function profileImage(Request $request)
    {
        $user = Auth::user();
        
        if ($request->has('uploaded_file')) {
            // Decode base64 data
            $uploaded_file_data = json_decode($request->input('uploaded_file'), true);

            if (isset($uploaded_file_data['dataURL'])) {
                $base64_data = $uploaded_file_data['dataURL'];
                $base64_image = substr($base64_data, strpos($base64_data, ',') + 1);
                $file_content = base64_decode($base64_image);

                // Generate file name
                $filename = time() . '_profile_image.jpg'; // Or use the original filename from JSON

                // Define storage path
                $storagePath = public_path('storage/profile_images');

                // Ensure the directory exists
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0777, true);
                }

                // Save file
                $stored = file_put_contents($storagePath . '/' . $filename, $file_content);

                // Check if file saved successfully
                if ($stored !== false) {
                    // Update database with file information
                    $user->profile_image = $filename;
                } else {
                    // Handle error if file couldn't be saved
                    return redirect()->back()->with('error', 'Dosya kaydedilirken bir hata oluştu.');
                }
            }
        }

        // Always update the hex code if provided
        if ($request->has('banner_hex_code')) {
            $user->banner_hex_code = $request->input('banner_hex_code');
        }

        $user->save();

        return redirect()->back()->with('success', 'İşlem başarılı bir şekilde gerçekleşmiştir.');
    }

    

    public function editPhone(Request $request)
    {
        // Form verilerini doğrula
        $user = Auth::user(); // Giriş yapmış kullanıcıyı al
    
        // Eğer kullanıcının zaten bir telefon numarası kaydı varsa, güncelle
        if ($user->phoneNumbers->isNotEmpty()) {
            $phoneNumber = $user->phoneNumbers->last(); // En son eklenen kaydı al
            $phoneNumber->update([
                'old_phone_number' => $user->mobile_phone,
                'new_phone_number' => $request->input('new_phone_number'),
                'phone_number_changed' => '0',
            ]);
        } else { // Eğer kullanıcının henüz bir telefon numarası kaydı yoksa, yeni bir kayıt oluştur
            $phoneNumber = $user->phoneNumbers()->create([
                'old_phone_number' => $user->mobile_phone,
                'new_phone_number' => $request->input('new_phone_number'),
            ]);
        }

        // if ($request->has('uploaded_file')) {
            if ($request->uploaded_file) {
        
            // Decode base64 data
            $uploaded_file_data = json_decode($request->input('uploaded_file'), true);

            $base64_data = $uploaded_file_data['dataURL'];


            $base64_image = substr($base64_data, strpos($base64_data, ',') + 1);
            $file_content = base64_decode($base64_image);

            // Generate file name
            $filename = time() . '_numberUpdate.jpg'; // Or use the original filename from JSON

            // Define storage path
            $storagePath = public_path('images');

            // Save file
            $stored = file_put_contents($storagePath . '/' . $filename, $file_content);

            // Check if file saved successfully
            if ($stored !== false) {
                // Update database with file information
                $phoneNumber->image_path = '/images/' . $filename; // Adjust path as necessary
                $phoneNumber->file_name = $filename;
                $phoneNumber->save();
            } else {
                // Handle error if file couldn't be saved
                return redirect()->back()->with('error', 'Dosya kaydedilirken bir hata oluştu.');
            }
        }
     
        return redirect()->back()->with('success', 'Telefon numarası değiştirme talebiniz destek ekibine iletilmiştir.');
    }


    public function individualProfileUpdate(Request $request)
    {
       

        // Validate the input fields
        $request->validate([
            "name" => "required|string|max:255",
            "iban" => "required|string|max:34|iban_tr", // IBAN genellikle maksimum 34 karakterdir
            // "profile_image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048", // Profil resminin geçerli bir resim dosyası olup olmadığını kontrol eder
        ]);
    
       
        // Retrieve the authenticated user
        $user = Auth::user();
    
        // Update user information
        $user->name = $request->input('name');
        $user->İban = $request->input('iban');
    
        // // Check if a new profile image has been uploaded
        // if ($request->hasFile('profile_image')) {
        //     // Store the new profile image and get its path
        //     $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
    
        //     // Delete the old profile image if it exists
        //     if ($user->profile_image) {
        //         Storage::disk('public')->delete($user->profile_image);
        //     }
    
        //     // Update the user's profile image path
        //     $user->profile_image = $profileImagePath;
        // }
    
        // Save the updated user information
        $user->save();
    
        // Redirect the user back with a success message
        return redirect()->back()->with('success', 'Profiliniz başarıyla güncellendi.');
    }
    
    
    public function update(Request $request)
    {
        $request->validate([
            "name" => "required",
            "iban" => function ($attribute, $value, $fail) use ($request) {
                if (auth()->user()->has_club == 1 && empty($value)) {
                    $fail('Iban alanı zorunludur');
                }
            },
            "banner_hex_code" => "required",
        ], [
            "name.required" => "İsim alanı zorunludur",
            "iban.required" => "Iban alanı zorunludur",
            "banner_hex_code.required" => "Mağaza arka plan rengi alanı zorunludur",
        ]);

        $user = User::where("id", Auth::user()->id)->first();

        // Vergi Dairesi İli'nin şehir kimliğini alın
        $city = City::where("title", $request->input("taxOfficeCity"))->first();
        $taxOfficeCityId = $city ? $city->id : null;
        $year = $request->input("year");
        $bank_name = $request->input("bank_name");
        // $phone = $request->input("phone");
        $longitude = $request->input("longitude");
        $latitude = $request->input("latitude");
        $website = $request->input("website");


        $data = $request->except('area_code');

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
        // $data['phone'] = $phone;
        $data['longitude'] = $longitude;
        $data['latitude'] = $latitude;
        $data['website'] = $website;

        
        $user->update($data);

        return redirect()->back();
    }

    public function clubUpdate(Request $request)
    {

        if (Auth::user()->type == "1") {
            $request->validate(
                [
                    "idNumber" => "required",
                    "bank_name" => "required",
                    "iban" => "required|iban",
                    "check-d" => "required"
                ],
                [
                    "idNumber.required" => "TC Kimlik Numarası alanı zorunludur.",
                    "bank_name.required" => "Banka Adı alanı zorunludur.",
                    "iban.iban" => "Lütfen geçerli bir iban giriniz.",
                    "iban.required" => "IBAN alanı zorunludur.",
                    "check-d.required" => "Onay kutusu zorunludur."
                ]
            );
        }else{
            $request->validate(
                [
                    "bank_name" => "required",
                    "iban" => "required|iban",
                    "check-d" => "required"
                ],
                [
                    "bank_name.required" => "Banka Adı alanı zorunludur.",
                    "iban.iban" => "Lütfen geçerli bir iban giriniz.",
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

        $emailTemplate = EmailTemplate::where('slug', "apply-emlak-kulup")->first();

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
            "email" => $user->email,
            "token" => $user->email_verification_token,
        ];

        foreach ($variables as $key => $value) {
            $content = str_replace("{{" . $key . "}}", $value, $content);
        }

        Mail::to($user->email)->send(new CustomMail($emailTemplate->subject, $content));
        $notificationText = "Emlak Kulüp başvurunuz alındı. Başvurunuz inceleniyor, en kısa sürede size geri dönüş yapılacaktır. Teşekkür ederiz!";

        DocumentNotification::create([
            'user_id' => 4,
            'text' => $notificationText,
            'item_id' => $user->parent_id ?? $user->id,
            'link' => route('institutional.index'),
            'owner_id' => $user->parent_id ?? $user->id,
            'is_visible' => true,
        ]);

           // Kullanıcının telefon numarasını al
           $userPhoneNumber = $user->mobile_phone;

           // Kullanıcının adını ve soyadını al
           $name = $user->name;

           // SMS metni oluştur
           $message = "Emlak Kulüp başvurunuz alınmıştır. Bilgileriniz incelendikten sonra hesabınız aktif edilecektir.";

           // SMS gönderme işlemi
           $smsService = new SmsService();
           $source_addr = 'Emlkspette';

           $smsService->sendSms($source_addr, $message, $userPhoneNumber);

        return  view("client.panel.home.has-club-status");
    }

}
