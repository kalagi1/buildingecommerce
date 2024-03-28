<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\CartOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Services\SmsService;

class ContractController extends Controller {
    protected $smsService;

    public function __construct( SmsService $smsService ) {
        $this->smsService = $smsService;
    }

    public function sendContractReminder( CartOrder $cartOrder, Request $request ) {
        $storeEmail = $cartOrder->store->email;
        $storePhone = $cartOrder->store->phone ? $cartOrder->store->phone : $cartOrder->store->mobile_phone;
        $smsContent = $request->input( 'sms_content' );
        $emailContent = $request->input( 'email_content' );

        if ( isset( $storeEmail ) ) {
            Mail::to( $storeEmail )->send( new CustomMail( 'Emlak Sepette | Sipariş için Sözleşme Hatırlatma', $emailContent ) );
        }

        if ( isset( $storePhone ) ) {
            $source_addr = 'MaliyetinEv';
            $message = $smsContent;
            $dest = $storePhone;

            $campaign_id =  $this->smsService->sendSms( $source_addr, $message, $dest );
        }

        return redirect()->back()->with( 'success', 'Sözleşme hatırlatma başarıyla gönderildi.' );
    }

}
