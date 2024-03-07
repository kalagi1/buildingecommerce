<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NestPayService; 
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class NestPayController extends Controller
{

    protected $storeNumber = '190100000';
    protected $adminUsername = '190933121admin';
    protected $adminPassword = 'TEST1010';
    protected $apiUsername = '190933121api';
    protected $apiPassword = 'TEST1010';
    protected $storeKey = '123456';
    protected $reportLoginUrl = 'https://entegrasyon.asseco-see.com.tr/ziraat/report/user.login';
    protected $threeDUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dgate';
    protected $apiUrl = 'https://entegrasyon.asseco-see.com.tr/fim/api';

    public function loginToReport(Request $request)
    {
        // Kullanıcı girişi için gerekli verileri hazırla
        $credentials = [
            'AdminUserName' => $this->adminUsername,
            'Password' => $this->adminPassword,
            'StoreKey' => $this->storeKey,
        ];

        // Rapora giriş yapmak için isteği oluştur
        $response = Http::post($this->reportLoginUrl, $credentials);

        // Yanıtı işle
        $responseData = $response->json();

        // İşlemleri yap

        return $responseData;
    }

    public function initiate3DPayment(Request $request)
    {
        // Ödeme yapılacak tutar ve diğer bilgileri al
        //$amount = $request->input('amount');
        // Diğer gerekli bilgileri al

        // Statik veriler
        $clientId = '190100000';
        $oid = '1291899411421';
        $amount = '91.96';
        $okUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';
        $failUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';
        $callbackUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';
        $transactionType = 'Auth';
        $installment = '2';
        $rnd = '5';
        $storeKey = '123456';
        $storetype = '3d_pay';
        $hashAlgorithm = 'ver3';
        $currency = '949';
        
        // // Hash oluşturma
        $plaintext = $clientId . $oid . $amount . $okUrl . $failUrl . $transactionType . $installment . $rnd . $callbackUrl . $storeKey ;
        // $hash = base64_encode(sha1($plaintext, true));

        // 3D ödeme için gerekli verileri hazırla
        $data = [
            'clientid' => $clientId,
            'oid' => $oid,
            'amount' => $amount,
            'okurl' => $okUrl,
            'failurl' => $failUrl,
            //'callbackurl' => $callbackUrl,
            'trantype' => $transactionType,
            'instalment' => $installment,
            'rnd' => $rnd,
            'storekey' => $storeKey,
            'storetype' => $storetype,
            'hashAlgorithm' => $hashAlgorithm,
            'currency' => $currency,
            'Ecom_Payment_Card_ExpDate_Month' => '12',
            'Ecom_Payment_Card_ExpDate_Year' => '26',
            'maskedCreditCard' => '5218487962459752',
            'MaskedPan' =>'5218487962459752',
            //'plaintext ' =>$plaintext,
            //'hash' => $hash
        ];

        //ksort($data); // Parametreleri alfabetik olarak sırala

                /// Parametreleri "|" karakteri ile birleştirerek hash verisini oluştur
        $dataString = implode('|', array_map(function ($key, $value) {
            // Değer içinde "|" karakterini "\|" olarak değiştir
            $value = str_replace('|', '\|', $value);
            // Değer içinde "\" karakterini "\\" olarak değiştir
            $value = str_replace('\\', '\\\\', $value);
            return $key . '=' . $value;
        }, array_keys($data), $data));

        //print_r($dataString);die;
        // İşyeri Güvenli Anahtarı (storeKey) sona ekle
        $dataString .= '|' . $storeKey;

        // Hash hesapla
        $hash = base64_encode(sha1($dataString, true));

        // Oluşturduğumuz hash'i $data array'ine ekle
        $data['hash'] = $hash;


       // HTTP isteği için ayarlar
        // $options = [
        //     'http' => [
        //         'method' => 'POST',
        //         'header' => 'Content-type: application/x-www-form-urlencoded',
        //         'content' => http_build_query($data),
        //     ],
        // ];
        $response = Http::asForm()->post($this->threeDUrl, $data);
        $result = $response->body();
        // İsteği oluştur

        // $context = stream_context_create($options);
        // $result = file_get_contents($this->threeDUrl, false, $context);

        return $result;
    }

    public function apiPayment(Request $request)
    {
        // Ödeme yapılacak tutar ve diğer bilgileri al
        $amount = $request->input('amount');
        // Diğer gerekli bilgileri al

        // API üzerinden ödeme için gerekli verileri hazırla
        $data = [
            // Gerekli verilerinitiate3DPaymenti doldur
        ];

        // API ödeme isteğini oluştur
        $response = Http::post($this->apiUrl, $data);

        // Yanıtı işle
        $responseData = $response->json();

        // İşlemleri yap

        return $responseData;
    }




    // protected $nestPayService;

    // public function __construct(NestPayService $nestPayService)
    // {
    //     $this->nestPayService = $nestPayService;
    // }
   

    public function index(){
        return view('nestpay.index');
    }

    // public function processPayment()
    // {
    // // Statik form verileri
    //  $formData = [
    //     'clientid' => '190100000',
    //     'storetype' => '3d_pay_hosting',
    //     'storekey' => '123456',
    //     'islemtipi' => 'Auth',
    //     'amount' => '91.96',
    //     'currency' => '949',
    //     'oid' => '1291899411421',
    //     'okUrl' => 'http://buildingecommerce.test/payment/success',
    //     'failUrl' => 'http://buildingecommerce.test/payment/fail',
    //     'callbackurl' => 'http://buildingecommerce.test/payment/callback',
    //     'lang' => 'tr',
    //     'rnd' => 'asdf',
    //     'pan' => '5218487962459752',
    //     'Ecom_Payment_Card_ExpDate_Year' => '26',
    //     'Ecom_Payment_Card_ExpDate_Month' => '12',
    //     'BillToCompany' => 'test',
    //     'BillToName' => 'test'
    // ];

    
    // // Hash değerini oluştur
    // $hashData = $this->generateHash($formData);

    // // Hash verisini form verilerine ekle
    // $formData['hash'] = $hashData;
    // print_r($formData);die;
    // // Guzzle istemcisini oluştur
    // $client = new Client();

    
    //         // POST isteği gönder
    //         $response = $client->post('https://entegrasyon.asseco-see.com.tr/fim/est3dgate', [
    //             'form_params' => $formData,
    //         ]);

            
            
    //         // Yanıtı işle
    //         $statusCode = $response->getStatusCode();
    //         $body = $response->getBody()->getContents();
            
    //         $responseData = json_decode($body, true);
    //         return $body;
    //         if ($responseData !== null) {
    //             if (isset($responseData['Response']) && $responseData['Response'] === 'Approved') {
    //                 // İşlem başarılı
    //                 return redirect()->route('payment.success');
    //             } elseif (isset($responseData['ErrMsg'])) {
    //                 // İşlem başarısız
    //                 $errorMessage = $responseData['ErrMsg'];
    //                 return redirect()->route('payment.fail')->with('error', $errorMessage);
    //             } else {
    //                 // Yanıtta beklenmeyen
    //                 return redirect()->route('payment.fail')->with('error', 'Beklenmeyen bir hata oluştu');
    //             }
    //         } else {
    //             // Yanıt null ise
    //             return redirect()->route('payment.fail')->with('error', 'Beklenmeyen bir hata oluştu');
    //         }
    // }

    // function generateHash($data)
    //     {
    //         // Parametreleri alfabetik sıraya göre sırala
    //         ksort($data);
            
    //         // Hash değeri hesaplama için kullanılacak string
    //         $hashString = '';
            
    //         // Parametrelerin değerlerinde bulunan | ve \ karakterlerini uygun şekilde değiştir ve hash string'ine ekle
    //         foreach ($data as $key => $value) {
    //             // Eğer parametre adı hash değilse
    //             if (strtolower($key) !== 'hash') {
    //                 // Parametre değerindeki | ve \ karakterlerini değiştir
    //                 $escapedValue = str_replace(['|', '\\'], ['\|', '\\\\'], $value);
                    
    //                 // Hash string'ine ekle
    //                 $hashString .= $escapedValue . '|';
    //             }
    //         }
            
    //         // Hash string'ine storeKey değerini de ekle
    //         $hashString .= $data['storekey'];
            
    //         // SHA-512 algoritması ile hash'i hesapla ve base64 ile kodla
    //         $calculatedHash = hash('sha512', $hashString, true);
    //         $encodedHash = base64_encode($calculatedHash);
            
    //         return $encodedHash;
    //     }
    public function success(Request $request)
    {
        $requestData = $request->all();
        print_r($requestData); die;
        return view('nestpay.success', ['requestData' => $requestData]);
    }

    public function fail(Request $request)
    {
       
        $requestData = $request->all();
        
        return view('nestpay.fail', ['requestData' => $requestData]);
            
    }


    // public function callback(Request $request)
    // {
      

    //     $requestData = $request->all();
    //     dd($requestData);
    //     return view('nestpay.callback', ['requestData' => $requestData]);
    // }

}
