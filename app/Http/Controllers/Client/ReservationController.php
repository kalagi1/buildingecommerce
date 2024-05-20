<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CartPrice;
use App\Models\Click;
use App\Models\Collection;
use App\Models\Housing;
use App\Models\Rate;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\SharerPrice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\BankAccount;

class ReservationController extends Controller
{

    public function reservation(Housing $housing)
    {
        $reservation = session()->get('reservation_data');
            if (!$reservation) {
                return redirect()->back()->with('error', 'Rezervasyon verisi bulunamadı, lütfen tekrar rezervasyon yapınız.');
            }
       
        $bankAccounts = BankAccount::all();

        

        $housingId = $housing->id;

        $housing = null;
      
        if (isset($reservation) && !empty($reservation)) {
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
                    DB::raw('(SELECT status FROM cart_orders WHERE JSON_EXTRACT(cart, "$.type") = "housing" AND JSON_EXTRACT(cart, "$.item.id") = housings.id ORDER BY created_at DESC LIMIT 1) AS sold'),
                    'cities.title AS city_title',
                    'districts.ilce_title AS county_title',
                    'neighborhoods.mahalle_title AS neighborhood_title',
                    DB::raw('(SELECT discount_amount FROM offers WHERE housing_id = housings.id AND type = "housing" AND start_date <= "' . date('Y-m-d H:i:s') . '" AND end_date >= "' . date('Y-m-d H:i:s') . '" ORDER BY start_date DESC LIMIT 1) as discount_amount'),
                    )
                ->leftJoin('housing_types', 'housing_types.id', '=', 'housings.housing_type_id')
                ->leftJoin('project_list_items', 'project_list_items.housing_type_id', '=', 'housings.housing_type_id')
                ->leftJoin('housing_status', 'housings.status_id', '=', 'housing_status.id')
                ->leftJoin('cities', 'cities.id', '=', 'housings.city_id')
                ->leftJoin('districts', 'districts.ilce_key', '=', 'housings.county_id')
                ->leftJoin('neighborhoods', 'neighborhoods.mahalle_id', '=', 'housings.neighborhood_id')
                ->where('housings.status', 1)
                ->where("housings.id",  $housingId)
                ->where('project_list_items.item_type', 2)
                ->orderByDesc('housings.created_at')
                ->first();

                $saleType = $housing->step2_slug;
                
        }

        $housing_type_data = json_decode($housing['housing_type_data'], true);
        $image = $housing_type_data['image'];

      

        $check_in_date = Carbon::parse($reservation['check_in_date']);
        $check_out_date = Carbon::parse($reservation['check_out_date']);

        
        // Tarih aralığı farkını hesapla
        $diffDate = $check_out_date->diffInDays($check_in_date); 
        $payPrice = $reservation['total_price'] / 2;
       
        return view('payment.reservation.index', compact('payPrice','diffDate','image','reservation', 'bankAccounts', 'housing'));

    }

    public function reservation3DPayment(Request $request){
        $housing = Housing::where('id', $request->id)->first();
        if($housing){

            $transaction = Str::uuid();


            $reservation = new Reservation;
            $reservation->user_id = auth()->user()->id;
            $reservation->housing_id = $request->input('id');
            $reservation->check_in_date = $request->input('check_in_date');
            $reservation->check_out_date = $request->input('check_out_date');
            $reservation->person_count = $request->input('person_count');
            $reservation->owner_id = $request->input('owner_id');
            $reservation->status = 0;
            if ($request->input('money_trusted') == true) {
                $reservation->money_trusted = 1;
                
            }
            //bu değerleri almalısın
            $reservation->total_price = $request->input('total_price');
            $reservation->price = $request->input('price');
            $reservation->money_is_safe = $request->input('money_is_safe');
            //
            $reservation->key = $request->input('key');
            $reservation->full_name = $request->input('fullName');
            $reservation->email = $request->input('email');
            $reservation->tc = $request->input('tc');
            $reservation->phone = $request->input('phone');
            $reservation->address = $request->input('address');
            $reservation->notes = $request->input('notes');
            $reservation->transaction = $transaction;
            $reservation->save();


            // total_price değerine eğer money_is_safe var ise dahil ederek yollaman gerekiyor 
            //çünkü param güvende seçilmiştir.

            // $reservation->full_name = $request->input('fullName');
            // $reservation->email = $request->input('email');
            // $reservation->tc = $request->input('tc');
            // $reservation->phone = $request->input('phone');
            // $reservation->address = $request->input('address');
            // $reservation->notes = $request->input('notes');
            // $reservation->transaction = $transaction;
            // $reservation->save();

            $requestData = $request->all();   
          
            $clientId = '190100000';
            $storeKey = '123456';
           
            $amountToBePaid = ($reservation->total_price / 2) + $reservation->money_is_safe; 

            $amount = $amountToBePaid ;
            $expDateMonth = $requestData['month'];
            $expDateYear = $requestData['year'];
            $okUrl = url('/reservation/resultpaymentsuccess');
            $failUrl = url('/reservation/resultpaymentfail');
            $callbackUrl = url('/reservation/resultpaymentsuccess');
            // $url = url('/resultpayment');
            $transactionType = 'Auth';
            $rnd = '5';
            $storetype = '3d_pay_hosting';
            $hashAlgorithm = 'ver3';
            $currency = '949';
            $lang = 'tr';
    
            $creditCardNumbers = implode('', $requestData['creditcard']);
    
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
                'oid' => $transaction,
                'okurl' => $okUrl,
                'pan' => $creditCardNumbers,
                'rnd' => $rnd,
                'storetype' => $storetype,
                'taksit'  => '',
            ];
    
            $order = [
                'amount', 'callbackurl', 'clientid', 'currency', 'Ecom_Payment_Card_ExpDate_Month', 'Ecom_Payment_Card_ExpDate_Year', 'failurl', 'hashAlgorithm',
                'islemtipi', 'lang', 'oid', 'okurl', 'pan', 'rnd', 'storetype', 'taksit'
            ];
    
            $sortedValues = array_map(function ($key) use ($data) {
                return $data[$key];
            }, $order);
    
            $hashString = implode('|', $sortedValues) . '|';
            $hashString .= str_replace('|', '\\|', str_replace('\\', '\\\\', $storeKey));
            $calculatedHashValue = hash('sha512', $hashString);
            $actualHash = base64_encode(pack('H*', $calculatedHashValue));
            $data['hash'] = $actualHash;

            return view('payment.pay', $data);
        }
        
        $error = "Rezervasyon bulunamadı. Tekrar Rezarvasyon Yapınız";
        return view('payment.reservation.index', compact('error'));

    }


    public function resultPaymentSuccess(Request $request)
    {
        $data = $request->all();
    
        $reservation = Reservation::where('transaction', $data['ReturnOid'])->first();
    
        if ($reservation) {
            $user = $reservation->user;
    
            if ($user) {
                Auth::login($user);
                $reservationId = $reservation->id;
    
                $reservation->status = '1';
                $reservation->payment_result = $data;
                $reservation->save();
    
                $lastClick = Click::where('user_id', auth()->user()->id)
                    ->where('created_at', '>=', now()->subDays(24))
                    ->latest('created_at')
                    ->first();
    
                $earnMoney = intval($reservation->total_price) / 2;
    
                if ($lastClick) {
                    $collection = Collection::where('id', $lastClick->collection_id)->first();
                    $rates = Rate::where("housing_id", $reservation->housing_id)->get();
                    $housing = Housing::where('id', $reservation->housing_id)->first();
    
                    // SharerPrice'i bul
                    $sharerPrice = SharerPrice::where('reservation_id', $reservation->id)->first();
    
                    if ($sharerPrice) {
                        // SharerPrice varsa, güncelle
                        $sharerPrice->status = '1';
                        $sharerPrice->save();
                    } else {
                        $sales_rate_club = null; // Başlangıçta boş veya null değer
    
                        foreach ($rates as $rate) {
                            if ($collection->user->corporate_type == $rate->institution->name) {
                                // Eğer kullanıcı kurumsal türü ile oranlar eşleşirse, `sales_rate_club` değerini atayın
                                $sales_rate_club = $rate->sales_rate_club;
                            }
                            if ($housing->user->corporate_type == $rate->institution->name) {
                                $share_percent_earn =  $rate->default_deposit_rate;
                                $share_percent_balance = 1.0 - $share_percent_earn;
                            }
                        }
    
                        // Eşleşme yoksa, son oran kaydının `sales_rate_club` değerini kullanın
                        if ($sales_rate_club === null && count($rates) > 0) {
                            $sales_rate_club = $rates->last()->sales_rate_club;
                        }
    
                        $estateclubrate = ($earnMoney * $share_percent_balance) * $sales_rate_club;
                        $remaining = $earnMoney * $share_percent_earn;
    
                        // Yeni SharerPrice oluştur
                        SharerPrice::create([
                            'collection_id' => $lastClick->collection_id,
                            'user_id' => $collection->user_id,
                            'status' => '1',
                            'balance' => $estateclubrate,
                            'earn' => $earnMoney * $share_percent_balance,
                            'earn2' => $remaining,
                            'is_reservation' => 1,
                            'reservation_id' => $reservation->id,
                        ]);
                    }
                } else {
                    $housing = Housing::where('id', $reservation->housing_id)->first();
                    $rates = Rate::where("housing_id", $reservation->housing_id)->get();
    
                    foreach ($rates as $key => $rate) {
                        if ($housing->user->corporate_type == $rate->institution->name) {
                            $share_percent_earn =  $rate->default_deposit_rate;
                            $share_percent_balance = 1.0 - $share_percent_earn;
                        }
                    }
    
                    $cartPrice = CartPrice::where('reservation_id', $reservation->id)->first();

                    if ($cartPrice) {
                        // CartPrice varsa, güncelle
                        $cartPrice->status = '1';
                        $cartPrice->save();
                    } else {
                        // CartPrice bulunamazsa, yeni bir öğe oluştur
                        CartPrice::create([
                            'user_id' => $housing->user_id,
                            'status' => '1',
                            'earn' =>  $earnMoney * $share_percent_balance,
                            'earn2' =>  $earnMoney * $share_percent_earn,
                            'is_reservation' => 1,
                            'reservation_id' => $reservation->id,
                        ]);
                    }
                }
                return redirect()->route('reservation.pay.success',compact('reservation'));
            }
        }
    
        return redirect()->route('client.login');
    }
    

    public function resultPaymentFail(Request $request)
    {
        $data = $request->all();

        $reservation = reservation::where('transaction', $data['oid'])->first();


        if ($reservation) {
            // Siparişi bulduysanız, bu siparişe ait kullanıcıyı alın
            $user = $reservation->user;

            if ($user) {
                // Kullanıcıyı oturum açın
                Auth::login($user);
                session()->forget('reservation_data');
                $reservation->delete();
                // Kullanıcıyı oturum açtıktan sonra hata mesajı ile birlikte ödeme sayfasına yönlendirin
                return redirect()->route('payment.reservation.index', ['userId' => $user->id])->with('error', 'Ödeme işlemi başarısız oldu.');
            }
        }

        // Kullanıcı veya sipariş bulunamazsa, giriş sayfasına yönlendirin veya başka bir işlem yapın
        return redirect()->route('client.login');
    }

    public function addsessions(Request $request)
    {

       
        // Doğrulama
        $validator = Validator::make($request->all(), [
            'housing_id' => 'required|exists:housings,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'person_count' => 'required|integer|min:1',
            'owner_id' => 'required',
            'price' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'money_is_safe' => 'nullable|numeric|min:0',
            'key' => 'required',
            
        ]);
    
        // Doğrulama başarısız ise hata mesajı döndür
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Geçersiz istek.', 'errors' => $validator->errors()]);
        }
    
        // Tüm rezervasyon verilerini bir dizi içinde toplama
        $reservationData = [
            'housing_id' => $request->input('housing_id'),
            'check_in_date' => $request->input('check_in_date'),
            'check_out_date' => $request->input('check_out_date'),
            'person_count' => $request->input('person_count'),
            'owner_id' => $request->input('owner_id'),
            'price' => $request->input('price'),
            'total_price' => $request->input('total_price'),
            'money_is_safe' => $request->input('money_is_safe'),
            'key' => $request->input('key'),
            'money_trusted' => $request->input('money_trusted')
        ];
    
        // Rezervasyon verilerini session'a kaydetme
        session()->put('reservation_data', $reservationData);

        return response()->json(['success' => true, 'message' => 'Rezervasyon başarıyla kaydedildi.']);
    
        // Devam eden işlemler...
    }
    
    public function paySuccess(Request $request, reservation $reservation)
    {

        return view('payment.reservation.pay-success', compact('reservation'));
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'housing_id' => 'required|exists:housings,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'person_count' => 'required|integer|min:1',
            'owner_id' => 'required',
            'price' => 'required|numeric|min:0',
            'key' => 'required',
            
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tc' => 'required|numeric',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Geçersiz istek.', 'errors' => $validator->errors()]);
        }

      

        $existingReservation = Reservation::where('housing_id', $request->input('housing_id'))
            ->where("status", "!=", "3")
            ->where(
                function ($query) use ($request) {
                    $query->whereBetween('check_in_date', [$request->input('check_in_date'), $request->input('check_out_date')])
                        ->orWhereBetween('check_out_date', [$request->input('check_in_date'), $request->input('check_out_date')]);
                }
            )
            ->first();

        if ($existingReservation) {
            return response()->json(['success' => false, 'message' => 'Bu tarih aralığında rezervasyon yapılamaz.']);
        }

        $lastClick = Click::where('user_id', auth()->user()->id)
            ->where('created_at', '>=', now()->subDays(24))
            ->latest('created_at')
            ->first();
        $shareOpen = isset(
            json_decode(Housing::find($request->input('housing_id') ?? 0)->housing_type_data ?? '[]')->{'share-open1'}
        ) ? json_decode(Housing::find($request->input('housing_id') ?? 0)->housing_type_data ?? '[]')->{'share-open1'}
            : null;

        $reservation = new Reservation;
        $reservation->user_id = auth()->user()->id;
        $reservation->housing_id = $request->input('housing_id');
        $reservation->check_in_date = $request->input('check_in_date');
        $reservation->check_out_date = $request->input('check_out_date');
        $reservation->person_count = $request->input('person_count');
        $reservation->owner_id = $request->input('owner_id');
        $reservation->status = 0;
        if ($request->input('money_trusted') == true) {
            $reservation->money_trusted = 1;
        }
        //bu değerleri almalısın
        $reservation->total_price = $request->input('total_price');
        $reservation->price = $request->input('price');

        if ($request->input('money_trusted') == false) {
            $reservation->money_is_safe = 0;
        }else
        {
            $reservation->money_is_safe = $request->input('money_is_safe');
        }

        $reservation->key = $request->input('key');
        $reservation->full_name = $request->input('fullName');
        $reservation->email = $request->input('email');
        $reservation->tc = $request->input('tc');
        $reservation->phone = $request->input('phone');
        $reservation->address = $request->input('address');
        $reservation->notes = $request->input('notes');

        $reservation->save();
        $earnMoney = intval($request->input('total_price')) / 2;
        if ($lastClick) {
            $collection = Collection::where('id', $lastClick->collection_id)->first();
            $rates = Rate::where("housing_id", $request->input('housing_id'))->get();
            $housing = Housing::where('id', $request->input('housing_id'))->first();


            $sales_rate_club = null; // Başlangıçta boş veya null değer

            foreach ($rates as $rate) {
                if ($collection->user->corporate_type == $rate->institution->name) {
                    // Eğer kullanıcı kurumsal türü ile oranlar eşleşirse, `sales_rate_club` değerini atayın
                    $sales_rate_club = $rate->sales_rate_club;
                }
                if ($housing->user->corporate_type == $rate->institution->name) {
                    $share_percent_earn =  $rate->default_deposit_rate;
                    $share_percent_balance = 1.0 - $share_percent_earn;
                }
            }

            // Eşleşme yoksa, son oran kaydının `sales_rate_club` değerini kullanın
            if ($sales_rate_club === null && count($rates) > 0) {
                $sales_rate_club = $rates->last()->sales_rate_club;
            }

            $estateclubrate = ($earnMoney * $share_percent_balance) * $sales_rate_club;
            $remaining = $earnMoney * $share_percent_earn;

            SharerPrice::create([
                'collection_id' => $lastClick->collection_id,
                'user_id' => $collection->user_id,
                'status' => '0',
                'balance' => $estateclubrate,
                'earn' => $earnMoney * $share_percent_balance,
                'earn2' => $remaining,
                'is_reservation' => 1,
                'reservation_id' => $reservation->id,
            ]);
        } else {
            $housing = Housing::where('id', $request->input('housing_id'))->first();
            $rates = Rate::where("housing_id", $request->input('housing_id'))->get();

            foreach ($rates as $key => $rate) {
                if ($housing->user->corporate_type == $rate->institution->name) {
                    $share_percent_earn =  $rate->default_deposit_rate;
                    $share_percent_balance = 1.0 - $share_percent_earn;
                }
            }

            CartPrice::create([
                'user_id' => $housing->user_id,
                'status' => '0',
                'earn' =>  $earnMoney * $share_percent_balance,
                'earn2' =>  $earnMoney * $share_percent_earn,
                'is_reservation' => 1,
                'reservation_id' => $reservation->id,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Rezervasyon başarıyla kaydedildi.','reservation' => $reservation->id]);
    }

    public function dekontFileUpload(Request $request)
    {
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('dekont'), $fileName);
        $reservation = reservation::where('id', $request->reservation)->first();
        // $cartOrder->update( [ 'dekont' => 'uploads/' . $fileName ] );
        // $cartOrder->save();

        if ($reservation) {
            // Dosya adının veritabanına kaydedilmesi
            $reservation->update(['dekont' => $fileName]);
            $reservation->save();
            return response()->json(['success' => 'Dosya başarıyla yüklendi.','reservation' => $reservation->id]);
        } else {
            return response()->json(['error' => 'reservation  bulunamadı.']);
        }
    }
}
