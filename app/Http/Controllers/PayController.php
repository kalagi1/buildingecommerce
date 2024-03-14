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
    
    
     
    //test ortamı 
    protected $storeNumber = '190100000';
    protected $adminUsername = '190933121admin';
    protected $adminPassword = 'TEST1010';
    protected $apiUsername = '190933121api';
    protected $apiPassword = 'TEST1010';
    protected $storeKey = '123456';
    protected $reportLoginUrl = 'https://entegrasyon.asseco-see.com.tr/ziraat/report/user.login';
    protected $testUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dgate';
    protected $apiUrl = 'https://entegrasyon.asseco-see.com.tr/fim/api';
    protected $testStoreUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';
    

    public function index()
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $cart = session()->get('cart', []);
        $bankAccounts = BankAccount::all();
        

        $saleType = null;
        if ( isset( $cart ) && !empty( $cart ) ) {
            if ( $cart[ 'type' ] == 'housing' ) {
                $housing = Housing::where( 'id', $cart[ 'item' ][ 'id' ] )->first();
                $saleType = $housing->step2_slug;
            } else {
                $project = Project::where( 'id', $cart[ 'item' ][ 'id' ] )->first();
                $saleType = $project->step2_slug;
            }
        }

        return view('payment.index', compact('user','cart','bankAccounts','saleType'));
    }

    
    public function initiate3DPayment(Request $request)
    {
        $requestData = $request->all();
        $userId = $this->getUserId($requestData);
        $storeId = $this->getStoreId($requestData);
        $amount = $this->calculateAmount($requestData);
        $cartOrder = $this->createCartOrder($requestData, $userId, $storeId, $amount);
        $orderId = $this->getOrderId($cartOrder);
        $data = $this->preparePaymentData($requestData,$orderId, $amount);
        return view('payment.pay', $data);
    }

    private function getUserId($requestData)
    {
        $user = Auth::user(); 
        return $user->id;
    }

    private function getStoreId($requestData)
    {
        $cartArray = json_decode($requestData['cart'], true);
        if($cartArray['type'] === 'project'){
            $project = Project::where('id', $cartArray['item']['id'])->first();
            return $project->user->id;
        } else {
            $housing = Housing::where('id', $cartArray['item']['id'])->first();
            return $housing->user_id;
        }
    }

    private function calculateAmount($requestData)
    {
        $cartArray = json_decode($requestData['cart'], true);
        return $cartArray['item']['amount'] - $cartArray['item']['discount_amount'];
    }

    private function createCartOrder($requestData, $userId, $storeId, $amount)
    {

        $referenceCode = null;
        if (isset($requestData['reference_code'])) {
           $user = User::where('code', $requestData['reference_code'])->first();
           $user ? $referenceCode = $user->id : null;
        }

        $isReference = null;
        if (isset($requestData['is_reference'])) {
           $userReference = User::where('id', $requestData['is_reference'])->first();
           $userReference ? $isReference = $userReference->id : null;
        }

        $cartArray = json_decode($requestData['cart'], true);
        $cartOrder = new CartOrder();
        $cartOrder->user_id = $userId;
        $cartOrder->status = '2';
        $cartOrder->bank_id = '2';
        $cartOrder->store_id = $storeId;
        $cartOrder->cart = $requestData['cart'];
        $cartOrder->full_Name = $requestData['fullName'];
        $cartOrder->email = $requestData['email'];
        $cartOrder->tc = $requestData['tc'];
        $cartOrder->phone = $requestData['phone'];
        $cartOrder->notes = $requestData['notes'];
        $cartOrder->address = $requestData['address'];
        $cartOrder->is_swap = isset($cartArray['item']['payment-plan'])  && $cartArray['item']['payment-plan'] == 'pesin' ? 0 : 1;
        $cartOrder->reference_id = $referenceCode;
        $cartOrder->is_reference = $isReference;
        $cartOrder->amount = $amount;
        $cartOrder->save();
        return $cartOrder;
    }

    private function getOrderId($cartOrder)
    {
        return $cartOrder->id;
    }

    private function preparePaymentData($requestData,$orderId, $amount)
    {
        $clientId = '190100000';
        $storeKey = '123456';
        $expDateMonth = $requestData['month'];
        $expDateYear = $requestData['year'];
        $okUrl = url('/resultpaymentsuccess');
        $failUrl = url('/resultpaymentfail');
        $callbackUrl = url('/resultpaymentsuccess');
       // $url = url('/resultpayment');
        $transactionType = 'Auth';
        $rnd = '5';
        $storetype = '3d_pay_hosting';
        $hashAlgorithm = 'ver3';
        $currency = '949';
        $lang = 'tr';
        
        $data = [
            'amount' => $amount,
            'callbackurl' =>  $callbackUrl,
            'clientid' => $clientId,
            'currency' => $currency,
            'Ecom_Payment_Card_ExpDate_Year' =>  $expDateYear,
            'Ecom_Payment_Card_ExpDate_Month' => $expDateMonth,
            'failurl' =>  $failUrl,
            'hashAlgorithm' => $hashAlgorithm,
            'islemtipi' => $transactionType,
            'lang' => $lang,
            'oid' => $orderId,
            'okurl' => $okUrl,
            'pan' => $requestData['creditcard'],
            'rnd' => $rnd,
            'storetype' => $storetype, 
            'taksit'  => '',
        ];

        $order = ['amount', 'callbackurl', 'clientid','currency','Ecom_Payment_Card_ExpDate_Month','Ecom_Payment_Card_ExpDate_Year', 'failurl', 'hashAlgorithm',
                'islemtipi','lang','oid', 'okurl','pan' ,'rnd', 'storetype','taksit'];

        $sortedValues = array_map(function ($key) use ($data) {
            return $data[$key];
        }, $order);

        $hashString = implode('|', $sortedValues) . '|';
        $hashString .= str_replace('|', '\\|', str_replace('\\', '\\\\', $storeKey));
        $calculatedHashValue = hash('sha512', $hashString);
        $actualHash = base64_encode(pack('H*', $calculatedHashValue));
        $data['hash'] = $actualHash;

        return $data;
    }


    public function resultPaymentSuccess(Request $request)
    {
        $data = $request->all();

        //dd($data);    
        $existingOrder = CartOrder::where('id', $data['ReturnOid'])->first();
        $existingOrder->payment_result = json_encode($data); 
        $existingOrder->status = '1';
        $existingOrder->save();

        $user = $existingOrder->user;

        if ($user) {
            // Kullanıcıyı oturum aç
            Auth::login($user);
             $existingOrderId = $existingOrder->id;
            return redirect()->route('pay.success', ['cart_order' =>$existingOrderId] );
            // Oturum açma başarılı olduğunda yapılacak işlemler
            
        }

        return redirect()->route('client.login');
        // müşteriye başarılı ödendi sayfasını göster
        

    }
    public function resultPaymentFail(Request $request)
    {
        $data = $request->all();

        $existingOrder = CartOrder::where('id', $data['ReturnOid'])->first();

        
        if ($existingOrder) {
            // Siparişi bulduysanız, bu siparişe ait kullanıcıyı alın
            $user = $existingOrder->user;

            if ($user) {
                // Kullanıcıyı oturum açın
                Auth::login($user);

                // Kullanıcıyı oturum açtıktan sonra hata mesajı ile birlikte ödeme sayfasına yönlendirin
                return redirect()->route('payment.index', ['userId' => $user->id])->with('error', 'Ödeme işlemi başarısız oldu.');

            }
        }

        // Kullanıcı veya sipariş bulunamazsa, giriş sayfasına yönlendirin veya başka bir işlem yapın
        return redirect()->route('client.login');
       
    }
}
