<?php
namespace App\Services;

use GuzzleHttp\Client;

class SmsService
 {
    protected $client;

    public function __construct()
 {
        $this->client = new Client( [
            'base_uri' => 'https://sms.verimor.com.tr/v2/',
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'auth' => [ '908502417542', 'GoMeed2021!!!' ], // Verimor kullanıcı adı ve şifrenizi buraya girin
        ] );
    }

    public function sendSms( $header, $message, $phones )
 {
        $sms_msg = array(
            'username' => '908502417542', // https://oim.verimor.com.tr/sms_settings/edit adresinden öğrenebilirsiniz.
            'password' => 'GoMeed2021!!!', // https://oim.verimor.com.tr/sms_settings/edit adresinden belirlemeniz gerekir.
            'source_addr' => $header, // Gönderici başlığı, https://oim.verimor.com.tr/headers adresinde onaylanmış olmalı, değilse 400 hatası alırsınız.
            //    'valid_for' => '48:00',
            //    'send_at' => '2015-02-20 16:06:00',
            //    'datacoding' => '0',
            'custom_id' => '1424441160.9331344',
            'messages' => array(
                array(
                    'msg' => $message,
                    'dest' => $phones
                )
            )
        );
        $ch = curl_init( 'https://sms.verimor.com.tr/v2/send.json' );
        curl_setopt_array( $ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array( 'Content-Type: application/json' ),
            CURLOPT_POSTFIELDS => json_encode( $sms_msg ),
        ) );
        $http_response = curl_exec( $ch );
        $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        if ( $http_code != 200 ) {
            echo "$http_code $http_response\n";
            return false;
        }

        return $http_response;
    }
}
