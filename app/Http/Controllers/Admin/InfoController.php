<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartPrice;
use App\Models\ContactInfo;
use App\Models\DocumentNotification;
use App\Models\SharerPrice;
use App\Models\User;
use App\Models\CartOrderRefund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


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
        // CartPrice ve SharerPrice modellerini tek bir sorguda alalım
        $cartPrices = CartPrice::with("cart.user", "cart.refund")->where("status", "1")->get();
        $sharerPrices = SharerPrice::with("cart.user", "user", "cart.refund")->where("status", "1")->get();
    
        // İki koleksiyonu birleştirerek tek bir koleksiyon oluşturalım
        $mergedArray = $cartPrices->concat($sharerPrices);
    
        // Filtrasyon işlemini gerçekleştirelim
        $filteredArray = $mergedArray->filter(function ($item) {
            // Öncelikle cart ilişkisinin varlığını ve null olup olmadığını kontrol edelim
            if (!$item->cart || !$item->cart->relationLoaded('refund')) {
                return false;
            }
    
            // refund ilişkisinin durumunu kontrol edelim
            $refundStatus = $item->cart->refund->status;
            return in_array($refundStatus, [2]);
        });
    
        // Sonuçları tarihe göre sıralayalım
        $filteredArray = $filteredArray->sortByDesc('cart.created_at');
    
        // Toplam kazancı hesaplayalım
        $totalEarn = $filteredArray->sum(function ($item) {
            $cleanedEarn = str_replace(['.', ','], '', $item->earn);
            return floatval($cleanedEarn);
        });
    
        // View'e verileri gönderelim
        return view('admin.accounting.index', ['mergedArray' => $filteredArray, 'totalEarn' => $totalEarn]);
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
