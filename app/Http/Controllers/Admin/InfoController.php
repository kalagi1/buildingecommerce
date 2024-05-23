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
        $cartPrices = CartPrice::with("cart.user")->where("status","1")->get();
        $sharerPrices = SharerPrice::with("cart.user","user")->where("status","1")->get();
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

        $cartPrices = CartPrice::with("cart.user",'cart.store')->where("status", "1")
            ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
            ->get()
            ->map(function ($item) {
                $item->source = 'cartPrices';
                return $item;
            });

        $sharerPrices = SharerPrice::with("cart.user",'cart.store', "user")->where("status", "1")
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
        $cartPrices = CartPrice::with("cart.user",'cart.store')
            ->where("status", ["1"])
            ->get()
            ->map(function ($item) {
                $item->source = 'cartPrices';
                return $item;
            });

        $sharerPrices = SharerPrice::with("cart.user",'cart.store', "user")
            ->where("status", "1")
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


    public function expenseExcel(Request $request)
    { 
        $startDate =$request->input('start_date');
        $endDate =$request->input('end_date');

        if (isset($request->mergedArray)){
            $parsedData = json_decode($request->mergedArray, true);
            ExpenseExport::truncate();
            foreach ($parsedData as $item){
                
                $cartContent = json_decode($item['cart']['cart'], true);
                $advertNo = '';
                if($cartContent['type'] == 'housing' ){
                    $advertNo = $cartContent['item']['id'] + 2000000;

                }else{
                    $advertNo = $cartContent['item']['id'] + 1000000;
                }
                
                    if($item['source'] && $item['source'] == 'cartPrices'){
                        if($item['earn2'] && $item['earn2'] != 0)
                        {
                            ExpenseExport::create([
                                'name' => $item['cart']['store']['name'] ?? null,
                                'email' => $item['cart']['store']['email'] ?? null,
                                'phone' => $item['cart']['store']['phone'] ?? null,
                                'bank_name' => $item['cart']['store']['bank_name'] ?? null,
                                'iban' => $item['cart']['store']['iban'] ?? null,
                                'account_type' => 'Kurumsal',
                                'amount' => $item['earn2']  ?? null,
                                'pay_status' => $item['payment_earn2'] == 1 ? 'Ödeme Yapıldı' : 'Ödeme Yapılmadı',
                                'advert_no' => $advertNo ?? null,
                                'advert_date' => date('Y-m-d H:i:s', strtotime($item['cart']['created_at'])),
                            ]);
                        }
                        }
                    
                    else
                    {
                        if($item['balance'] && $item['user'] && $item['balance'] != 0 )
                        {
                            ExpenseExport::create([
                                'name' => $item['user']['name'] ?? null,
                                'email' => $item['user']['email'] ?? null,
                                'phone' => $item['user']['phone'] ?? null,
                                'bank_name' => $item['user']['bank_name'] ?? null,
                                'iban' => $item['user']['iban'] ?? null,
                                'account_type' => 'Emlak Kulüp',
                                'amount' => $item['balance']  ?? null,
                                'pay_status' => $item['payment_balance'] == 1 ? 'Ödeme Yapıldı' : 'Ödeme Yapılmadı',
                                'advert_no' => $advertNo ?? null,
                                'advert_date' => date('Y-m-d H:i:s', strtotime($item['cart']['created_at'])),
                            ]);

                        }
                        if($item['earn2'] && $item['earn2'] != 0)
                        {

                            ExpenseExport::create([
                                'name' => $item['cart']['store']['name'] ?? null,
                                'email' => $item['cart']['store']['email'] ?? null,
                                'phone' => $item['cart']['store']['phone'] ?? null,
                                'bank_name' => $item['cart']['store']['bank_name'] ?? null,
                                'iban' => $item['cart']['store']['iban'] ?? null,
                                'account_type' => 'Kurumsal',
                                'amount' => $item['earn2'] ?? null,
                                'pay_status' => $item['payment_earn2'] == 1 ? 'Ödeme Yapıldı' : 'Ödeme Yapılmadı',
                                'advert_no' => $advertNo ?? null,
                                'advert_date' => date('Y-m-d H:i:s', strtotime($item['cart']['created_at'])),
                            ]);
                        }
                        

                    }   

            } 

            if ($startDate && $endDate) {
                // Başlangıç ve bitiş tarihleri belirtilmişse, filtrelenmiş verileri kullanarak indirme yap
                $fileName = $startDate . ' - ' . $endDate . ' - ' . 'GiderTablosu.xlsx';
            } else {
                // Başlangıç ve bitiş tarihleri belirtilmemişse, tüm verileri kullanarak indirme yap
                $fileName = 'TümGiderTablosu.xlsx';
            }
    
            return Excel::download(new ExpensesExport(), $fileName);

        }

            return redirect()->back()->with('error', 'Sipariş bulunamadı');
        
    }


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
}
