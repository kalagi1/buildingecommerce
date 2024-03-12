<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BankAccount;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use App\Models\CartOrder;
use App\Models\Project;
use App\Models\Housing;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\View;
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
        //dd($request->all());

        //cart bilgileri ile payment return jsonları ayrı mı tutulmalı sor 
        //status 1 olduğu halde neden satıldı olmuyor 
        //bankid sorulacak
        //store id nedir sorulacak
        //sorulacak reference_id nedir
        

        //taksik olacak mı sorulacak
        $requestData = $request->all();

        // Kullanıcı bilgilerini al
        $fullName = $requestData['fullName'];
        $email = $requestData['email'];
        $tc = $requestData['tc'];
        $phone = $requestData['phone'];
        $address = $requestData['address'];
        $notes = $requestData['notes'];
        $hasReference = null;
        $isReference = null;

        if ($requestData['reference_code']) {
            $hasReference = User::where('code', $requestData['reference_code'])->first();
        }
        if ($requestData['is_reference']) {
            $isReference = User::where('id', $requestData['is_reference'])->first();
        }
        
        
        $key = $requestData['key'];
        $creditcard = $requestData['creditcard'];
        $month = $requestData['month'];
        $year = $requestData['year'];
        $cartJson = $request->input('cart');

        
        // // JSON dizesini diziye dönüştür
        $cartArray = json_decode($cartJson, true);
      
        // dd($cartArray);
        $storeId = null;

        if($cartArray['type'] === 'project'){
            $project = Project::where('id', $cartArray['item']['id'])->first();
            $storeId = $project->user->id;
        }
        else{
            $housing = Housing::where('id', $cartArray['item']['id'])->first();
            $storeId = $housing->user_id;
        }
       

        $amount = $cartArray['item']['amount'] - $cartArray['item']['discount_amount'];

        $user = Auth::user(); 
        $userId = $user->id;

        $cartOrder = new CartOrder();
        $cartOrder->user_id = $userId;
        $cartOrder->key = $key;
       
        $cartOrder->bank_id = '';

        $cartOrder->store_id = $storeId;
        $cartOrder->cart = $cartJson;
        $cartOrder->full_Name = $fullName;
        $cartOrder->email = $email;
        $cartOrder->tc = $tc;
        $cartOrder->phone = $phone;
        $cartOrder->notes = $notes;
        $cartOrder->address = $address;
        $cartOrder->is_swap = $cartArray['item']['pesinat']== 'pesin' ? 0 : 1;
      
        $cartOrder->reference_id = $hasReference ? $hasReference->id : null;
        $cartOrder->is_reference = $isReference ? $isReference->id : null;

        $cartOrder->amount = $amount;
        $cartOrder->save();


        $clientId = '190100000';
        $storeKey = '123456';

        
        $orderid = $key;
        $amount = $amount;
        
        $installment = '';
        $creditCard = $creditcard;
        $expDateMonth = $month;
        $expDateYear = $year;

        // $okUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';
        // $failUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';
        // $callbackUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';

        $url = url('/resultpayment');;
       
        $transactionType = 'Auth';
        $rnd = '5';
        $storetype = '3d_pay_hosting';
        $hashAlgorithm = 'ver3';
        $currency = '949';
        $lang = 'tr';
        
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

        return view('payment.pay', $data);
       
    }

    public function resultPayment(Request $request)
    {
        $data = $request->all();
        $paymentStatus = $data['Response'];
        
        if ($paymentStatus === 'Approved')
        {
            $existingOrder = CartOrder::where('key', $data['ReturnOid'])->first();
            $existingOrder->payment_result = json_encode($data); 
            $existingOrder->status = '1';
            $existingOrder->save();
        } 
        else{

            $existingOrder = CartOrder::where('key', $data['oid'])->first();
            $existingOrder->payment_result = json_encode($data); 
            $existingOrder->status = '0';
            $existingOrder->save();

        }

            

        // müşteriye başarılı ödendi sayfasını göster
        return view('payment.resultpage');

    }
}
