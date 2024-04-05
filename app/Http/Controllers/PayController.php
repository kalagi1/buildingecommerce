<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BankAccount;
use App\Models\CartItem;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use App\Models\CartOrder;
use App\Models\Project;
use App\Models\Housing;
use App\Models\ProjectHousing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\View;
class PayController extends Controller
{
    //test ortamı 
    // protected $storeNumber = '190100000';
    // protected $adminUsername = '190933121admin';
    // protected $adminPassword = 'TEST1010';
    // protected $apiUsername = '190933121api';
    // protected $apiPassword = 'TEST1010';
    // protected $storeKey = '123456';
    // protected $reportLoginUrl = 'https://entegrasyon.asseco-see.com.tr/ziraat/report/user.login';
    // protected $testUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dgate';
    // protected $apiUrl = 'https://entegrasyon.asseco-see.com.tr/fim/api';
    // protected $testStoreUrl = 'https://entegrasyon.asseco-see.com.tr/fim/est3dteststore';

    public function index()
    {

        if (Auth::check()) {
           
            $userId = Auth::user()->id;
        
            // Oturum açmış kullanıcının işlemlerini burada devam ettirin
        } else {
            // Kullanıcı oturum açmamışsa, login sayfasına yönlendirin
            return redirect()->route('client.login'); // login sayfasının route ismini buraya yazın
        }
        
        $user = User::find($userId);
        $cartItem = CartItem::where('user_id', Auth::user()->id)->latest()->first();

        $cart = json_decode($cartItem->cart, true);
        dd($cart);

        // dd($cart);
        $bankAccounts = BankAccount::all();
        

        $saleType = null;
        $column_name = null;
        $project = null;
        $projectHousingsList = [];
        $projectHousings = null;

        $housing = null;

        if ( isset( $cart ) && !empty( $cart ) ) {
            if ( $cart[ 'type' ] == 'housing' ) {
                $housing = Housing::with('images')
                ->select(
                    'housings.id',
                    'housings.slug',
                    'housings.title AS housing_title',
                    'housings.created_at',
                    'housings.step1_slug',
                    'housings.step2_slug',
                    'housing_types.title as housing_type_title',
                    'housings.housing_type_data',
                    'project_list_items.column1_name as column1_name',
                    'project_list_items.column2_name as column2_name',
                    'project_list_items.column3_name as column3_name',
                    'project_list_items.column4_name as column4_name',
                    'project_list_items.column1_additional as column1_additional',
                    'project_list_items.column2_additional as column2_additional',
                    'project_list_items.column3_additional as column3_additional',
                    'project_list_items.column4_additional as column4_additional',
                    'housings.address',
                    \Illuminate\Support\Facades\DB::raw('(SELECT status FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing" AND JSON_EXTRACT(cart, "$.item.id") = housings.id) AS sold'),
                    'cities.title AS city_title',
                    'districts.ilce_title AS county_title',
                    'neighborhoods.mahalle_title AS neighborhood_title',
                    DB::raw('(SELECT discount_amount FROM offers WHERE housing_id = housings.id AND type = "housing" AND start_date <= "' . date('Y-m-d H:i:s') . '" AND end_date >= "' . date('Y-m-d H:i:s') . '") as discount_amount'),
                )
                ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
                ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
                ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
                ->leftJoin('cities', 'cities.id', '=', 'housings.city_id')
                ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id')
                ->leftJoin('neighborhoods', 'neighborhoods.mahalle_id', '=', 'housings.neighborhood_id')
                ->where('housings.status', 1)
                ->where("housings.id",$cart['item']['id'])
                ->where('project_list_items.item_type', 2)
                ->orderByDesc('housings.created_at')
                ->first();
            
                $saleType = $housing->step2_slug; 
            } else {
                $project = Project::where( 'id', $cart[ 'item' ][ 'id' ] )->first();
                $saleType = $project->step2_slug;
                $projectHousings = ProjectHousing::where('project_id', $project->id)->get();

                $combinedValues = $projectHousings->map(function ($item) use (&$projectHousingsList) {
                    $projectHousingsList[$item->room_order][$item->name] = $item->value;
                });   
                

               
            }
        }

    

        return view('payment.index', compact('user', 'cart', 'bankAccounts', 'saleType', 'project', 'projectHousingsList', 'projectHousings', 'housing'));
    }

    
    public function initiate3DPayment(Request $request)
    {
        $requestData = $request->all();

        //dd($requestData);
        $userId = $this->getUserId($requestData);
        $storeId = $this->getStoreId($requestData);
        $amount = $this->calculatePayableAmount($requestData);
        $cartOrder = $this->createCartOrder($requestData, $userId, $storeId, $amount);
        $orderId = $this->getOrderId($cartOrder);
        $data = $this->preparePaymentData($requestData,$orderId, $amount);
        return view('payment.pay', $data);
    }

    private function preparePaymentData($requestData,$orderId, $amount)
    {
        // $clientId = '190100000';
        // $storeKey = '123456';
        $clientId = '190933121';
        $storeKey = 'MasteR3457';
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

    private function calculatePayableAmount($requestData)
    {
        return $requestData['payable_amount'];
    }


    // private function calculateAmount($requestData)
    // {
    //     $cartArray = json_decode($requestData['cart'], true);
    //     return $cartArray['item']['amount'] - $cartArray['item']['discount_amount'];
    // }

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
        $cartOrder->key = $requestData['key'];
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

        $existingOrder = CartOrder::where('id', $data['oid'])->first();

        
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
