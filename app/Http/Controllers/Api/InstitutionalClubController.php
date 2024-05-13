<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\DocumentNotification;
use App\Models\EmailTemplate;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InstitutionalClubController extends Controller
{
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
        } else {
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

        return response()->json(['message' => 'success']);
    }
}
