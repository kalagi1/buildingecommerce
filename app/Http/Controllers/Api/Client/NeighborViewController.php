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
        $neighborViews = NeighborView::with(['user', 'owner', 'order'])
            ->where('user_id', $userId)
            ->orderByDesc("id")
            ->get();
    
        // Verilerin boş olup olmadığını kontrol et
        if ($neighborViews->isEmpty()) {
            return response()->json(['status' => 'fail', 'message' => 'Size ait bilgiler yok'], 404);
        }
    
        // İlk NeighborView öğesinin ilişkili Project'ini al
        $project = Project::with("brand", "situations", "blocks", "neighbourhood", "housingType", "county", "city", 'listItemValues', 'user.brands', 'user.housings', 'images')
            ->where('id', $neighborViews->first()->project_id)
            ->where("status", 1)
            ->first();
    
        // Proje var mı kontrol et
        if (!$project) {
            return response()->json(['status' => 'fail', 'message' => 'Proje yayından kaldırılmıştır'], 404);
        }
    
        // Diğer verileri hazırla
        $projectHousingSetting = ProjectHouseSetting::orderBy('order')->get();
    
        $projectCartOrders = DB::table('cart_orders')
            ->select(
                DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id'),
                DB::raw('JSON_EXTRACT(cart, "$.item.qt") as qt'),
                DB::raw('JSON_EXTRACT(cart, "$.item.qt") as qt_total'), // Added for total qt
                'cart_orders.status',
                'cart_orders.user_id',
                'cart_orders.store_id',
                'cart_orders.is_show_user',
                'cart_orders.id',
                'users.name',
                'users.mobile_phone',
                'users.phone'
            )
            ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
            ->whereJsonContains('cart->type', 'project')
            ->whereJsonContains('cart->item.id', $project->id)
            ->orderByRaw('CAST(JSON_EXTRACT(cart, "$.item.housing") AS SIGNED) ASC')
            ->get()
            ->keyBy("housing_id");
    
        $sumCartOrderQt = DB::table('cart_orders')
            ->select(
                DB::raw('JSON_EXTRACT(cart, "$.item.housing") as housing_id'),
                DB::raw('SUM(JSON_EXTRACT(cart, "$.item.qt")) as qt_total')
            )
            ->leftJoin('users', 'cart_orders.user_id', '=', 'users.id')
            ->whereJsonContains('cart->type', 'project')
            ->whereJsonContains('cart->item.id', $project->id)
            ->groupBy('housing_id')
            ->get()
            ->keyBy('housing_id');
    
        $offer = Offer::where('project_id', $project->id)
            ->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))
            ->first();
    
        $projectHousings = ProjectHousing::where('project_id', $project->id)
            ->where('room_order', '>', 0)
            ->where('room_order', '<=', 10)
            ->get();
        
        $projectHousingsList = $projectHousings->groupBy('room_order')
            ->map(function ($housingGroup) {
                return $housingGroup->pluck('value', 'name')->toArray();
            });
    
        // Favorileri kullanıcıya göre al
        $projectFavorites = [];
        if (auth()->guard("api")->check()) {
            $projectFavorites = ProjectFavorite::where('user_id', auth()->guard("api")->user()->id)
                ->where('project_id', $project->id)
                ->pluck('housing_id')
                ->toArray();
        }
    
        $parent = HousingTypeParent::where("slug", $project->step1_slug)->first();
    
        // Başarılı yanıtı döndür
        return response()->json([
            "status" => 'success',
            "data" => $neighborViews,
            "project" => $project,
            "offer" => $offer,
            "projectCartOrders" => $projectCartOrders,
            "projectHousingsList" => $projectHousingsList,
            "sumCartOrderQt" => $sumCartOrderQt,
            "parent" => $parent,
            "projectHousingSetting" => $projectHousingSetting,
            "projectFavorites" => $projectFavorites
        ], 200);
    }
     

}
