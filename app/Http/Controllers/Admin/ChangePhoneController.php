<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhoneNumber;
use App\Models\User;
class ChangePhoneController extends Controller
{
    public function index()
    {
        $phoneNumbers = PhoneNumber::with('user')->latest()->get();

        return view('admin.phone_number.index', compact('phoneNumbers'));
 
    }

    public function changePhoneNumberStatusByUser($userId)
    {  // Kullanıcıyı bul
        $user = User::findOrFail($userId);
    
        // Kullanıcının son eklenen telefon numarasını al
        $phoneNumber = $user->phoneNumbers()->latest()->first();
    
        // Eğer ilişkili bir telefon numarası yoksa, hata döndür
        if (!$phoneNumber) {
            return response()->json(['error' => 'Kullanıcıya ait telefon numarası bulunamadı.'], 404);
        }
    
        // Yeni telefon numarasını al
        $newPhoneNumber = $phoneNumber->new_phone_number;
    
        // Telefon numarasını değiştir ve durumu güncelle
        $user->mobile_phone = $newPhoneNumber;

        $user->phone_verification_status= '0';
        $phoneNumber->phone_number_changed = 1;
        
        // Kayıtları kaydet
        $user->save();
        $phoneNumber->save();
       
         return redirect()->back();
    }
}
