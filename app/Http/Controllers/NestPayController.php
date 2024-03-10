<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NestPayService; 
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
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
    protected $testStoreUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';

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
        $clientId = '190100000';
        $storeKey = '123456';


        $orderid = '1291333333324';
        $amount = '91.96';
        $installment = '2';
        $creditCard = '5218487962459752';
        $expDateMonth = '12';
        $expDateYear = '26';

        $okUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';
        $failUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';
        $callbackUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';
       
        $transactionType = 'Auth';
        $rnd = '5';
        $storetype = '3d_pay_hosting';
        $hashAlgorithm = 'ver3';
        $currency = '949';
        $lang = 'tr';
        
        //$maskedCreditCard = '5218487962459752';
    
        // Sıralanacak veriler
        $data = [
            'amount' => $amount,
            'callbackurl' => $callbackUrl,
            'clientid' => $clientId,
            'currency' => $currency,
            'Ecom_Payment_Card_ExpDate_Year' =>  $expDateYear ,
            'Ecom_Payment_Card_ExpDate_Month' => $expDateMonth,
            'failurl' => $failUrl,
            'hashAlgorithm' => $hashAlgorithm,
            'islemtipi' => $transactionType,
            'lang' => $lang,
            'oid' => $orderid,
            'okurl' => $okUrl,
            'pan' => $creditCard,
            'rnd' => $rnd,
            'storetype' => $storetype, 
            'taksit'  => $installment,   
        ];

        // Sıralama sırası
        $order = [
            'amount', 'callbackurl', 'clientid','currency','Ecom_Payment_Card_ExpDate_Month','Ecom_Payment_Card_ExpDate_Year', 'failurl', 'hashAlgorithm',
            'islemtipi','lang','oid', 'okurl','pan' ,'rnd', 'storetype','taksit'
            
        ];

        // Verileri sırala
        $sortedValues = array_map(function ($key) use ($data) {
            return $data[$key];
        }, $order);


        // Hash hesapla
        $hashString = implode('|', $sortedValues) . '|';
        $hashString .= str_replace('|', '\\|', str_replace('\\', '\\\\', $storeKey)); // storekey ekle
        //print_r($hashString);die;
        $calculatedHashValue = hash('sha512', $hashString);
        $actualHash = base64_encode(pack('H*', $calculatedHashValue));


        $data['hash'] = $actualHash;

        //print_r($data);die;
              // print_r($sortedString);die;
       // HTTP isteği için ayarlar
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($data),
            ],
        ];
        //print_r($data);die;
        $response = Http::asForm()->post($this->threeDUrl, $data);
        $result = $response->body();

        //dd($result);
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

   
    
    public function success(Request $request)
    {
        $requestData = $request->all();

      //  print_r($requestData); die;
        return view('nestpay.success', ['requestData' => $requestData]);
    }

    public function fail(Request $request)
    {
       
        $requestData = $request->all();
        return view('nestpay.fail', ['requestData' => $requestData]);

    }

    public function callback(Request $request)
    {
      

        $requestData = $request->all();
        dd($requestData);
        return view('nestpay.callback', ['requestData' => $requestData]);
    }

}
