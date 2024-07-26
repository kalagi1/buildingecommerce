<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\HousingFavorite;
use App\Models\ProjectFavorite;
use App\Models\ProjectHousing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Throwable;

class FavoriteController extends Controller
{
    public function index(){
        if(auth()->guard('api')->user()){
            $user = User::where("id", auth()->guard('api')->user()->id)->with("housingFavorites.housing", "housingFavorites.housing.listItems", 'housingFavorites.housing.city','housingFavorites.housing.county','housingFavorites.housing.neighborhood','housingFavorites.housing.brand')->first();
            $favorites = $user->housingFavorites;
            $projectFavorites = ProjectFavorite::where("user_id", auth()->guard('api')->user()->id)
                ->with('project.roomInfo', 'projectHousing','project.listItemValues','project.city','project.county','project.neighbourhood')
                ->orderBy("created_at", "desc")
                ->get();

            foreach($projectFavorites as $key => $favorite){
                if(isset($favorite['project_id']) && $favorite['project_id']){
                    $projectHousings = ProjectHousing::where('project_id', $favorite->project_id)->where('room_order', '<=', $favorite->project_id)->get();
                    $projectHousingsList = [];
                    $projectHousings->each(function ($item) use (&$projectHousingsList, &$salesCloseProjectHousingCount, &$projectCartOrders) {
                        $projectHousingsList[$item->room_order][$item->name] = $item->value;
                    });
                    $projectFavorites[$key]->project->listHousing = $projectHousingsList;
                }
            }
            
            $mergedFavorites = $favorites->merge($projectFavorites);
            $mergedFavorites = $mergedFavorites->sortByDesc('created_at');
            
            return json_encode([
                "user" => $user,
                "mergedFavorites" => $mergedFavorites,
            ]);
        }else{
            return Response::json([
                'message' => "Authorization Failed"
            ], 401);
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

    public function addProjectHousingToFavorites($id, Request $request)
    {
        $user = User::where("id", auth()->guard("api")->user()->id)->first();
        if(!$user){
            $status="notLogin";
            $message="Giriş Yapınız";

            return response()->json([
                'status'  => $status,
                'message' => $message
            ]);
        }

        $existingFavorite = ProjectFavorite::where('user_id', $user->id)
            ->where('housing_id', $id)
            ->where("project_id", $request->input("project_id"))
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            $message = "Ürün favorilerden kaldırıldı";
            $status = "removed";
        } else {
            ProjectFavorite::create([
                "user_id" => $user->id,
                'housing_id' =>  $request->input("housing_id"),
                "project_id" => $request->input("project_id"),
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
