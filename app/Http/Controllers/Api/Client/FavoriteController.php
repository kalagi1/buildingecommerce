<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\HousingFavorite;
use App\Models\ProjectFavorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Throwable;

class FavoriteController extends Controller
{
    public function index(){
        try{
            if(auth()->guard('api')->user()){
                $user = User::where("id", auth()->guard('api')->user()->id)->with("housingFavorites.housing", "housingFavorites.housing.listItems", 'housingFavorites.housing.city', 'housingFavorites.housing.brand')->first();
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
                    "mergedFavorites" => $mergedFavorites,
                    "projectFavorites" => $projectFavorites,
                ]);
            }else{
                return Response::json([
                    'message' => "Authorization Failed"
                ], 401);
            }
        }catch(Throwable $e){
            return Response::json([
                'message' => "Bad Request"
            ], 400);
        }
        
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
