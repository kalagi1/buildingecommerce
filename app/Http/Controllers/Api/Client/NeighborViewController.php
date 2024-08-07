<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Mail\CustomMail;
use App\Models\CartOrder;
use App\Models\EmailTemplate;
use App\Models\Housing;
use App\Models\NeighborView;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\BankAccount;
use App\Models\CartItem;
use App\Models\ProjectHousing;
use Illuminate\Support\Facades\Auth;
use App\Models\HousingStatus;
use App\Models\DocumentNotification;
use Illuminate\Support\Facades\DB;

class NeighborViewController extends Controller
{

    public function index()
    {
        // Auth kullanıcıyı alın
        $user = auth()->guard()->user();
        
        // Kullanıcıyı kontrol et
        if (!$user) {
            return response()->json(['status' => 'fail', 'message' => 'Kullanıcı giriş yapmamış'], 401);
        }

        // Kullanıcı ID'sini al
        $userId = $user->id;
  
        // NeighborView verilerini al
        $neighborViews = NeighborView::with(['user', 'owner', 'order', 'project'])
            ->where('user_id', $userId)
            ->orderByDesc("id")
            ->get();

        // Verilerin boş olup olmadığını kontrol et
        if ($neighborViews->isEmpty()) {
            return response()->json(['status' => 'fail', 'message' => 'Size ait bilgiler yok'], 404);
        }

        // Başarılı yanıt
        return response()->json(['status' => 'success', 'data' => $neighborViews], 200);
    }   

}
