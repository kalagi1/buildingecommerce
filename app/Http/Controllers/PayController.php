<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BankAccount;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use App\Models\CartOrder;
use Illuminate\Support\Facades\Auth;
class PayController extends Controller
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
    

    public function index($userId)
    {
        $user = User::find($userId);
        $cart = session()->get('cart', []);
        // $saleType = null;
        // if (isset($cart) && !empty($cart)) {
        //     if ($cart['type'] == 'housing') {
        //         $housing = Housing::where('id', $cart['item']['id'])->first();
        //         $saleType = $housing->step2_slug;
        //     } else {
        //         $project = Project::where('id', $cart['item']['id'])->first();
        //         $saleType = $project->step2_slug;
        //     }
        // }
        $bankAccounts = BankAccount::all();
        
        return view('payment.index', compact('user','cart','bankAccounts'));
    }

    public function initiate3DPayment(Request $request)
    {
      
        dd($request->all());
        $cartJson = $request->input('cart');

        // JSON dizesini diziye dönüştür
        $cartArray = json_decode($cartJson, true);
    
        // Pesinatı al
        $price = $cartArray['item']['pesinat'];

        $clientId = '190100000';
        $storeKey = '123456';
        //$csrfToken = $request->session()->token();
        // dd($price);
        
        $orderid = '2311123252';
        $amount = '91.96';
        $installment = '2';
        $creditCard = '5218487962459752';
        $expDateMonth = '12';
        $expDateYear = '26';

        // $okUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';
        // $failUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';
        // $callbackUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';

        $url = url('api/3dpayresponse');
       
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
            'callbackurl' =>  $url,
            'clientid' => $clientId,
            'currency' => $currency,
            'Ecom_Payment_Card_ExpDate_Year' =>  $expDateYear,
            'Ecom_Payment_Card_ExpDate_Month' => $expDateMonth,
            'failurl' =>  $url,
            'hashAlgorithm' => $hashAlgorithm,
            'islemtipi' => $transactionType,
            'lang' => $lang,
            'oid' => $orderid,
            'okurl' => $url,
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
        $paymentResult = $response->body();

        if ($response->successful()) {
            // İsteğin başarılı olduğu durumda kayıt işlemini gerçekleştirin
            $cartOrder = new CartOrder();
            $cartOrder->user_id = auth()->id();
            $cartOrder->key = $orderid;
            $cartOrder->store_id = $request;
            $cartOrder->cart = json_encode('null');
            $cartOrder->save();
        }


        return $paymentResult;
    }


    public function processPaymentResponse(Request $request)
    {
            // JSON verilerini diziye dönüştür
        $data = $request->all();

        // Ödeme durumunu kontrol et
        $paymentStatus = $data['Response'];

        // $paymentStatus kontrol edilmeden önce var olup olmadığını kontrol etmek iyi bir pratiktir
        if(isset($paymentStatus)) {
            // $paymentStatus kontrol ediliyor
            if ($paymentStatus === 'Approved') {

                $existingOrder = CartOrder::where('key', $data['ReturnOid'])->first();
                if ($existingOrder) {
                    // Kayıt varsa, güncelleme yapın
                    $existingOrder->cart = json_encode($data); // JSON verisinin 'cart' alanı
                    $existingOrder->amount = $data['amount']; 
                    $existingOrder->key = $data['ReturnOid'];
                    $existingOrder->status = '1';
                    $existingOrder->bank_id = 6;

                    // Güncelleme işlemini kaydet
                    $existingOrder->save();
            
                    return response()->json(['message' => 'Ödeme başarıyla tamamlandı ve veriler güncellendi'], 200);
                 
            } else {
                return response()->json(['error' => 'Ödeme işlemi başarısız oldu. Lütfen tekrar deneyin.'], 400);
            }
        } else {
            // Gelen verilerde 'Response' anahtarı bulunamadı
            return response()->json(['error' => 'Gelen verilerde Response anahtarı bulunamadı.'], 400);
        }

        
    }

    }
}
