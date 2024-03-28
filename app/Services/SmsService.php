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
        $sms_msg = [
            'source_addr' => $header,
            'messages' => [
                [
                    'msg' => $message,
                    'dest' => $phones
                ]
            ]
        ];

        $response = $this->client->post( 'send.json', [
            'json' => $sms_msg,
        ] );

        return $response->getBody()->getContents();
    }
}
