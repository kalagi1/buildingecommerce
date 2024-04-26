<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\ProjectFavorite;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(){
        $user = User::where("id", auth()->guard('api')->user()->id)->with("housingFavorites.housing", 'housingFavorites.housing.city', 'housingFavorites.housing.brand')->first();
        $favorites = $user->housingFavorites;
        $projectFavorites = ProjectFavorite::where("user_id", auth()->guard('api')->user()->id)
            ->with('project.roomInfo', 'projectHousing')
            ->orderBy("created_at", "desc")
            ->get();
        
        $mergedFavorites = $favorites->merge($projectFavorites);
        
        $mergedFavorites = $mergedFavorites->sortByDesc('created_at');
        
        return json_encode([
            "user" => $user,
            "favorites" => $favorites,
            "projectFavorites" => $projectFavorites,
            "mergedFavorites" => $mergedFavorites,
        ]);
    }

    public function addHousingToFavorites($id)
    {
        $user = User::where("id", auth()->guard('api')->user()->id)->first();
        if(!$user){
              $status="notLogin";
                $message="Giriş Yapınız";
            
            return response()->json([
                'status'  => $status,
                'message' => $message
            ]);
        }
        $housing = Housing::findOrFail($id);

        // Kullanıcının favorileri içinde bu konut zaten var mı kontrol et
        $existingFavorite = HousingFavorite::where('user_id', $user->id)
            ->where('housing_id', $housing->id)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            $message = "Ürün favorilerden kaldırıldı";
            $status = "removed";
        } else {
            HousingFavorite::create([
                "user_id" => $user->id,
                'housing_id' => $housing->id,
            ]);
            $message = "Ürün favorilere eklendi.";
            $status = "added";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
