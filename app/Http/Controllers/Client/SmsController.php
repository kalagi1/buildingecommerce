<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SmsService;

class SmsController extends Controller {
    protected $smsService;

    public function __construct( SmsService $smsService ) {
        $this->smsService = $smsService;
    }

    public function sendSms(Request $request)
{
    $header = 'BASLIGIM'; // SMS başlığı
    $message = 'asd'; // Gönderilecek mesaj
    $phones = '905075634137'; // Alıcı numarası

    // SmsService sınıfından sendSms metodu çağrılıyor
    $response = $this->smsService->sendSms($header, $message, $phones);

    // Sms gönderme işlemi sonucunu JSON olarak döndürülüyor
    return response()->json($response);
}

}
