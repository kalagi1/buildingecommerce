<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartPrice;
use App\Models\ContactInfo;
use App\Models\DocumentNotification;
use App\Models\SharerPrice;
use App\Models\User;
use App\Models\CartOrderRefund;
use App\Models\ExpenseExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExpensesExport;







class InfoController extends Controller
{
    public function markAsRead($id)
    {
        $notification = DocumentNotification::find($id);

        if ($notification) {
            $notification->readed = 1;
            $notification->save();
            return response()->json(['message' => 'Bildirim okundu olarak işaretlendi.',"status" => "readed"]);
        } else {
            return response()->json(['error' => 'Bildirim bulunamadı.'], 404);
        }
    }

    public function markAllAsRead()
{
    $unreadNotifications = DocumentNotification::where("owner_id",Auth::user()->id)->get();
    foreach ($unreadNotifications as  $value) {
        $value->update(['readed' => 1]);
    }

    return redirect()->back();
}

    public function setReadedDn(Request $request, DocumentNotification $dn)
    {
        $dn->update(['readed' => 1]);
        return redirect()->route('admin.user.show-corporate-account', ['user' => $dn->user_id]);
    }

    public function accounting()
    {
        $cartPrices = CartPrice::with("cart.user",'cart.store','reservation', 'reservation.user','reservation.owner','cart.refund', 'reservation.refund')->whereIn("status", ['1','2'])->get();
        $sharerPrices = SharerPrice::with("cart.user",'cart.store', "user", 'reservation', 'reservation.user','reservation.owner','cart.refund', 'reservation.refund')->whereIn("status", ['1','2'])->get();
        $mergedArray = $cartPrices->concat($sharerPrices);
        $mergedArray = $mergedArray->sortByDesc('cart.created_at');
        $totalEarn = $mergedArray->sum(function ($item) {
            $cleanedEarn = str_replace(['.', ','], '', $item->earn);
            return floatval($cleanedEarn);
        });

       
        return view('admin.accounting.index', ['mergedArray' => $mergedArray, 'totalEarn' => $totalEarn]);
    }


    public function filterByDate(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $payment_status =  $request->input('payment_status');

        $cartPrices = CartPrice::with("cart.user",'cart.store','reservation', 'reservation.user','reservation.owner','cart.refund', 'reservation.refund')->where("status", ['1','2'])
            ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
            ->get()
            ->map(function ($item) {
                $item->source = 'cartPrices';
                return $item;
            });

        $sharerPrices = SharerPrice::with("cart.user",'cart.store', "user", 'reservation', 'reservation.user','reservation.owner','cart.refund', 'reservation.refund')->where("status",  ['1','2'])
            ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
            ->get()
            ->map(function ($item) {
                $item->source = 'sharerPrices';
                return $item;
            });;

            
        $mergedArray = $cartPrices->concat($sharerPrices);
        $mergedArray = $mergedArray->sortByDesc('cart.created_at');

        

        return view('admin.accounting.expense', ['mergedArray' => $mergedArray]);
    }

    

    public function expense()
    {
        $cartPrices = CartPrice::with("cart.user",'cart.store','reservation' , 'reservation.user','reservation.owner', 'cart.refund', 'reservation.refund')
            ->whereIn("status", ['1','2'])
            ->get()
            ->map(function ($item) {
                $item->source = 'cartPrices';
                return $item;
            });

        $sharerPrices = SharerPrice::with("cart.user",'cart.store', "user" ,'reservation' , 'reservation.user','reservation.owner','cart.refund', 'reservation.refund')
            ->whereIn("status", ['1','2'])
            ->get()
            ->map(function ($item) {
                $item->source = 'sharerPrices';
                return $item;
            });

        $mergedArray = $cartPrices->concat($sharerPrices);
        $mergedArray = $mergedArray->sortByDesc('cart.created_at');

        $totalEarn = $mergedArray->sum(function ($item) {
            $cleanedEarn = str_replace(['.', ','], '', $item->earn);
            return floatval($cleanedEarn);
        });

        
        return view('admin.accounting.expense', [
            'mergedArray' => $mergedArray,
            'totalEarn' => $totalEarn
        ]);
    }


    // public function expenseExcel(Request $request)
    // { 


    //     $startDate =$request->input('start_date');
    //     $endDate =$request->input('end_date');

    //     if (isset($request->mergedArray)){
    //         $parsedData = json_decode($request->mergedArray, true);

    //         dd($parsedData);

    //         ExpenseExport::truncate();
    //         foreach ($parsedData as $item){
                   
    //             $advertNo = '';
    //             if($item['reservation'])
    //             {
    //                 $advertNo = $item['reservation']['housing_id'] + 2000000;

    //             }else
    //             {
    //                 $cartContent = json_decode($item['cart']['cart'], true);
    //                 if($cartContent['type'] == 'housing' ){
    //                     $advertNo = $cartContent['item']['id'] + 2000000;

    //                 }else{
    //                     $advertNo = $cartContent['item']['id'] + 1000000;
    //                 }
                 

    //             }

    //             if($item['cart']['refund'] || $item['reservation']['refund'])
    //             {

                   
    //                     ExpenseExport::create([
    //                         'name' => $item['cart']['user']['name'] ?? $item['reservation']['user']['name'],
    //                         'email' => $item['cart']['user']['email'] ?? $item['reservation']['user']['email'],
    //                         'phone' => $item['cart']['user']['phone'] ?? $item['reservation']['user']['phone'] ,
    //                         'bank_name' => $item['cart']['user']['bank_name'] ?? $item['reservation']['user']['bank_name'] ,
    //                         'iban' => $item['cart']['user']['iban'] ?? $item['reservation']['user']['iban'] ,
    //                         'account_type' => '',
    //                         'amount' => $item['cart']['refund']['return_amount'] ?? $item['reservation']['refund']['return_amount'],
    //                         'pay_status' => $item['cart']['refund']['status'] == 3 ? 'Ödeme Yapıldı' : 'Ödeme Yapılmadı',
    //                         'advert_no' => $advertNo ?? null,
    //                         'advert_date' => isset($item['cart']['created_at']) ? date('Y-m-d H:i:s', strtotime($item['cart']['created_at'])) :  date('Y-m-d H:i:s', strtotime($item['reservation']['created_at'])),
    //                     ]);


    //             }



    //                 if($item['source'] && $item['source'] == 'cartPrices'){
                       
                        
    //                         ExpenseExport::create([
    //                             'name' => $item['cart']['store']['name'] ?? $item['reservation']['owner']['name'],
    //                             'email' => $item['cart']['store']['email'] ?? $item['reservation']['owner']['email'],
    //                             'phone' => $item['cart']['store']['phone'] ?? $item['reservation']['owner']['phone'] ,
    //                             'bank_name' => $item['cart']['store']['bank_name'] ?? $item['reservation']['owner']['bank_name'] ,
    //                             'iban' => $item['cart']['store']['iban'] ?? $item['reservation']['owner']['iban'] ,
    //                             'account_type' => 'Kurumsal',
    //                             'amount' => $item['earn2'] ?? null,
    //                             'pay_status' => $item['payment_earn2'] == 1 ? 'Ödeme Yapıldı' : 'Ödeme Yapılmadı',
    //                             'advert_no' => $advertNo ?? null,
    //                             'advert_date' => isset($item['cart']['created_at']) ? date('Y-m-d H:i:s', strtotime($item['cart']['created_at'])) :  date('Y-m-d H:i:s', strtotime($item['reservation']['created_at'])),
    //                         ]);
                        
    //                 }
                    
    //                 else
    //                 {
    //                     if($item['balance'] && $item['user'] && $item['balance'] != 0 )
    //                     {
    //                         ExpenseExport::create([
    //                             'name' => $item['user']['name'] ?? null,
    //                             'email' => $item['user']['email'] ?? null,
    //                             'phone' => $item['user']['phone'] ?? null,
    //                             'bank_name' => $item['user']['bank_name'] ?? null,
    //                             'iban' => $item['user']['iban'] ?? null,
    //                             'account_type' => 'Emlak Kulüp',
    //                             'amount' => $item['balance'] ?? null,
    //                             'pay_status' => $item['payment_balance'] == 1 ? 'Ödeme Yapıldı' : 'Ödeme Yapılmadı',
    //                             'advert_no' => $advertNo ?? null,
    //                             'advert_date' => isset($item['cart']['created_at']) ? date('Y-m-d H:i:s', strtotime($item['cart']['created_at'])) : date('Y-m-d H:i:s', strtotime($item['reservation']['created_at'])),

    //                         ]);

    //                     }
    //                     if($item['earn2'] && $item['earn2'] != 0)
    //                     {

    //                         ExpenseExport::create([
    //                             'name' => $item['cart']['store']['name'] ?? $item['reservation']['owner']['name'],
    //                             'email' => $item['cart']['store']['email'] ?? $item['reservation']['owner']['email'],
    //                             'phone' => $item['cart']['store']['phone'] ?? $item['reservation']['owner']['phone'] ,
    //                             'bank_name' => $item['cart']['store']['bank_name'] ?? $item['reservation']['owner']['bank_name'] ,
    //                             'iban' => $item['cart']['store']['iban'] ?? $item['reservation']['owner']['iban'] ,
    //                             'account_type' => 'Kurumsal',
    //                             'amount' => $item['earn2'] ?? null,
    //                             'pay_status' => $item['payment_earn2'] == 1 ? 'Ödeme Yapıldı' : 'Ödeme Yapılmadı',
    //                             'advert_no' => $advertNo ?? null,
    //                             'advert_date' => isset($item['cart']['created_at']) ? date('Y-m-d H:i:s', strtotime($item['cart']['created_at'])) :  date('Y-m-d H:i:s', strtotime($item['reservation']['created_at'])),
    //                         ]);
    //                     }
                        

    //                 }   

    //         } 

    //         if ($startDate && $endDate) {
    //             // Başlangıç ve bitiş tarihleri belirtilmişse, filtrelenmiş verileri kullanarak indirme yap
    //             $fileName = $startDate . ' - ' . $endDate . ' - ' . 'GiderTablosu.xlsx';
    //         } else {
    //             // Başlangıç ve bitiş tarihleri belirtilmemişse, tüm verileri kullanarak indirme yap
    //             $fileName = 'TümGiderTablosu.xlsx';
    //         }
    
    //         return Excel::download(new ExpensesExport(), $fileName);

    //     }

    //         return redirect()->back()->with('error', 'Sipariş bulunamadı');
        
    // }


    public function updatePaymentStatus(Request $request)
    {
        $id = $request->input('id');
        $source = $request->input('source');
        $type = $request->input('type');
        $paymentStatus = $request->input('payment_status');
    
        if ($source === 'cartPrices') {
            $item = CartPrice::find($id);
            if ($item) {
                if ($type === 'payment_earn2') {
                    $item->payment_earn2 = $paymentStatus;
                }
                $item->save();
                return response()->json(['success' => true]);
            }
        } elseif ($source === 'sharerPrices') {
            $item = SharerPrice::find($id);
            if ($item) {
                if ($type === 'payment_balance') {
                    $item->payment_balance = $paymentStatus;
                } else {
                    $item->payment_earn2 = $paymentStatus;
                }
                $item->save();
                return response()->json(['success' => true]);
            }
        }
    
        return response()->json(['success' => false, 'message' => 'Kayıt bulunamadı veya geçersiz kaynak.']);
    }
    

    public function accountingForRefund()
    {
        // Şu anki zamanı al
        $now = Carbon::now();
        
        // CartOrderRefund'ları al, with('cartOrder') metodu ile ilişkili cartOrder verilerini de al
        $refunds = CartOrderRefund::with('cartOrder')
        ->whereIn('status', [1,3])
        ->orderBy('created_at', 'desc')
        ->get();

        $data = [];
        foreach ($refunds as $refund) {
            // İlişkili CartOrder'ı al
            $order = $refund->cartOrder;

            // CartOrder'ın oluşturulma tarihini al
            $createdAt = Carbon::parse($order->created_at);
            
            // Oluşturulma tarihi ile şu anki tarih arasındaki farkı gün cinsinden hesapla
            $differenceInDays = $createdAt->diffInDays($now);
            
            // Eğer oluşturulma tarihi 14 günü geçmemişse
            if ($differenceInDays <= 14) {
        
                $amount = $order->amount;

                // Virgülle ayrılmış formattaki sayıda virgülü noktaya dönüştür
                $amountFloat = (float) str_replace(',', '.', str_replace('.', '', $amount));
                //Emlak sepettenin
                $refundAmount = $amountFloat * 0.10;
                //Alıcının
                $recipientAmount = $amountFloat * 0.90;
    
            } else {

                $amount = $order->amount;
                $refundAmount =  $amount;
                $recipientAmount = (float)"0";

            }

            $data[] = [
                'refund' => $refund,
                'order' => $order,
                'refundAmount' => $refundAmount,
                'recipientAmount' => $recipientAmount
            ];
        }
        return view('admin.accounting.refund', compact('data'));
    }

    
    


    public function notificationHistory()
    {
        return view('admin.notification-history');
    }

    public function contact()
    {
        $contactInfo = ContactInfo::first();

        return view('admin.info.contact', compact('contactInfo'));
    }
    public function contactSetOrEdit()
    {
        // Validation kuralları
        $this->validate(request(), [
            'address' => 'required',
            'location' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'working_time' => 'required',
        ]);

        $contact_info = request()->only('address', 'location', 'phone', 'email', 'working_time');

        $contact_info_model = ContactInfo::first();

        if ($contact_info_model) {
            $contact_info_model->update($contact_info);
        } else {
            $contact_info_model = ContactInfo::create($contact_info);
        }

        return redirect()->route('admin.info.contact.index')->with('success', 'İletişim bilgileri kaydedildi');
    }


  

    private function getAdvertNo($item)
    {
        if (isset($item['reservation'])) {
            return $item['reservation']['housing_id'] + 2000000;
        } else {
            if (isset($item['cart']['cart'])) {
                $cartContent = json_decode($item['cart']['cart'], true);
                if ($cartContent['type'] == 'housing') {
                    return $cartContent['item']['id'] + 2000000;
                } else {
                    return $cartContent['item']['id'] + 1000000;
                }
            }
        }
        return null;
    }

    private function getReturnAmount($item)
    {
        return $item['cart']['refund']['return_amount'] ?? $item['reservation']['refund']['return_amount'] ?? '';
    }

    private function hasRefund($item)
    {
        return isset($item['cart']['refund']) || isset($item['reservation']['refund']);
    }

    public function expenseExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($request->has('mergedArray')) {
            $parsedData = json_decode($request->mergedArray, true);

            ExpenseExport::truncate();
            foreach ($parsedData as $item) {
                $advertNo = $this->getAdvertNo($item);
                $returnAmount = $this->getReturnAmount($item);

                if ($this->hasRefund($item)) {
                    $this->createExpenseExport($item, $returnAmount, $advertNo, 'refund');
                }

                if ($item['source'] == 'cartPrices') {
                    $this->createExpenseExport($item, $returnAmount, $advertNo, 'earn2');
                } else {
                    if ($item['source'] == 'sharerPrices' && $item['earn2'] && $item['earn2'] != 0) {
                        $this->createExpenseExport($item, $returnAmount, $advertNo, 'earn2');
                    }

                    if ($item['balance'] && $item['user'] && $item['source'] == 'sharerPrices' && $item['balance'] != 0) {
                        $this->createExpenseExport($item, $returnAmount, $advertNo, 'balance');
                    }
                }
            }

            $fileName = $startDate && $endDate ? "$startDate - $endDate - GiderTablosu.xlsx" : 'TümGiderTablosu.xlsx';
            return Excel::download(new ExpensesExport(), $fileName);
        }

        return redirect()->back()->with('error', 'Sipariş bulunamadı');
    }

    private function createExpenseExport($item, $returnAmount, $advertNo, $type)
    {
        // İlk önce değişkenleri tanımla
        $name = '';
        $email = '';
        $phone = '';
        $bank_name = '';
        $iban = '';
        $accountType = '';
        $amount = '';
        $payStatus = '';
        $advertDate = '';

        // Kullanılacak değişkenleri belirle
        if ($item['reservation'] && $item['reservation']['refund']) {
            $name = $item['reservation']['user']['name'] ?? null;
            $email = $item['reservation']['user']['email'] ?? null;
            $phone = $item['reservation']['user']['phone'] ?? null;
            $bank_name = $item['reservation']['user']['bank_name'] ?? null;
            $iban = $item['reservation']['user']['iban'] ?? null;
        } elseif ($item['cart'] && $item['cart']['refund']) {
            $name = $item['cart']['user']['name'] ?? null;
            $email = $item['cart']['user']['email'] ?? null;
            $phone = $item['cart']['user']['phone'] ?? null;
            $bank_name = $item['cart']['user']['bank_name'] ?? null;
            $iban = $item['cart']['user']['iban'] ?? null;
        } elseif ($item['source'] == 'cartPrices' && $item['earn2'] && $item['earn2'] != 0) {
            $name = $item['cart']['store']['name'] ?? $item['reservation']['owner']['name'] ?? null;
            $email = $item['cart']['store']['email'] ?? $item['reservation']['owner']['email'] ?? null;
            $phone = $item['cart']['store']['phone'] ?? $item['reservation']['owner']['phone'] ?? null;
            $bank_name = $item['cart']['store']['bank_name'] ?? $item['reservation']['owner']['bank_name'] ?? null;
            $iban = $item['cart']['store']['iban'] ?? $item['reservation']['owner']['iban'] ?? null;
        } elseif ($item['source'] == 'sharerPrices' && $item['earn2'] && $item['earn2'] != 0 && $type == 'earn2') {
            $name = $item['cart']['store']['name'] ?? $item['reservation']['owner']['name'] ?? null;
            $email = $item['cart']['store']['email'] ?? $item['reservation']['owner']['email'] ?? null;
            $phone = $item['cart']['store']['phone'] ?? $item['reservation']['owner']['phone'] ?? null;
            $bank_name = $item['cart']['store']['bank_name'] ?? $item['reservation']['owner']['bank_name'] ?? null;
            $iban = $item['cart']['store']['iban'] ?? $item['reservation']['owner']['iban'] ?? null;
        } elseif ($item['balance'] && $item['user'] && $item['source'] == 'sharerPrices' && $item['balance'] != 0 && $type == 'balance') {
            $name = $item['user']['name'] ?? null;
            $email = $item['user']['email'] ?? null;
            $phone = $item['user']['phone'] ?? null;
            $bank_name = $item['user']['bank_name'] ?? null;
            $iban = $item['user']['iban'] ?? null;
        }

        // Hesap türünü belirle
        if ($type == 'refund') {
            $accountType = 'Bireysel';
            $amount = $returnAmount;
            $payStatus = $item['cart']['refund']['status'] == 3 ? 'İade Ödemesi Talebi' : 'İade Talebi';
        } elseif ($type == 'earn2') {
            $accountType = 'Kurumsal';
            $amount = $item['earn2'] ?? null;
            $payStatus = $item['payment_earn2'] == 1 ? 'Ödeme Yapıldı' : 'Ödeme Yapılmadı';
        } elseif ($type == 'balance') {
            $accountType = 'Emlak Kulüp';
            $amount = $item['balance'] ?? null;
            $payStatus = $item['payment_balance'] == 1 ? 'Ödeme Yapıldı' : 'Ödeme Yapılmadı';
        }

        // Reklam tarihini belirle
        $advertDate = isset($item['cart']['created_at']) ? date('Y-m-d H:i:s', strtotime($item['cart']['created_at'])) : date('Y-m-d H:i:s', strtotime($item['reservation']['created_at']));


        $formattedAmount = number_format($amount, 2, ',', '.') . ' TL';
        // Veritabanına kayıt ekle
        ExpenseExport::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'bank_name' => $bank_name,
            'iban' => $iban,
            'account_type' => $accountType,
            'amount' => $formattedAmount,
            'pay_status' => $payStatus,
            'advert_no' => $advertNo ?? null,
            'advert_date' => $advertDate,
        ]);
    }
}
