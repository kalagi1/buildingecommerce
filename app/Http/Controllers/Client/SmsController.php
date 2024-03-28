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
    $source_addr = "MaliyetinEv";
    $message = "Test mesajıdır"; // Bu metin UTF8 olmalı, değilse 400 hatası alırsınız. Veritabanından alınan string'ler, veritabanı bağlantısının encoding'iyle gelir, UTF8 değilse çevirmeniz gerekir.
    $dest = "905075634137,";
    
    $campaign_id = $this->smsService->sendSms($source_addr, $message, $dest);
    if($campaign_id === false)
      echo "Mesaj gonderme basarisiz.\n";
    else
      echo "Mesaj basariyla gonderildi. Kampanya ID'si: $campaign_id\n";
}

}
