<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;
use Illuminate\Support\Facades\Response;

class SupportController extends Controller
{
    public function index()
    {
        // Kullanıcının giriş yapıp yapmadığını kontrol edin
        $user = auth()->guard()->user();

        if (!$user) {
            return response()->json(['status' => 'fail', 'message' => 'Kullanıcı giriş yapmamış'], 401);
        }

        // Kullanıcıya ait destek kayıtlarını alın
        $supports = Support::where('user_id', $user->id)->get();

        // Eğer destek kayıtları bulunamazsa uygun bir yanıt döndürün
        if ($supports->isEmpty()) {
            return response()->json(['status' => 'fail', 'message' => 'Destek kaydı bulunamadı'], 404);
        }

        // Başarılı yanıt
        return response()->json(['status' => 'success', 'data' => $supports], 200);
    }

    public function sendSupportMessage(Request $request)
    {
         // İstek verilerini doğrulayın
         $validatedData = $request->validate([
            'category' => 'required|string|max:255',
            'sendReason' => 'nullable|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Dosya türü ve boyutunu kontrol edin
        ]);

        // Dosya yükleme işlemi
        $fileName = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Benzersiz dosya ismi oluşturun
            $file->move(public_path('support'), $fileName);
        }

        // Support modeli ile yeni bir kayıt oluştur
        $support = new Support();
        $support->user_id = Auth::id();
        $support->category = $validatedData['category'];
        $support->send_reason = $validatedData['sendReason'] ?? null;
        $support->description = $validatedData['description'];
        $support->file_path = $fileName; // Dosya yolunu kaydet

        $support->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Talebiniz başarıyla alındı.',
            'data' => $support
        ], 201);
    } //End

   
   
}
