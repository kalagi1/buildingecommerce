<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\SmsService;

class SmsController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function MultipleSms()
    {
        return view('admin.multiple_sms.create');
    } //End

    public function MultipleSmsStore(Request $request)
    {
        $title = $request->title;
        $content = $request->content;
        $userIds = $request->selectedUsers;
        $dest = '';
    
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if ($user) {
                $phoneNumber = $user->phone ? $user->phone : $user->mobile_phone;
                // Telefon numarasını kontrol et ve dest değişkenine ekleyerek virgülle ayır
                if ($phoneNumber) {
                    $dest .= $phoneNumber . ',';
                }
            }
        }
    
        // Virgülle sonlanan dest değişkeninin sonundaki virgülü kaldır
        $dest = rtrim($dest, ',');
    
        // Eğer en az bir telefon numarası bulunursa SMS gönderme işlemini gerçekleştir
        if ($dest) {
            $campaign_id = $this->smsService->sendSms($title, $content, $dest);
    
            if ($campaign_id === false)
                return redirect()->back()->with('error', 'Sms Gönderilemedi.');
            else
                return redirect()->back()->with('success', 'Sms Başarıyla Gönderildi. Kampanya ID si :' . $campaign_id);
        } else {
            // Telefon numarası bulunamazsa hata mesajı döndür
            return redirect()->back()->with('error', 'Telefon numarası bulunamadı.');
        }
    }
    
    
}
