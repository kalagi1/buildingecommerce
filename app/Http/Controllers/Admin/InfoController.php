<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartPrice;
use App\Models\ContactInfo;
use App\Models\DocumentNotification;
use App\Models\SharerPrice;
use Illuminate\Http\Request;

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
