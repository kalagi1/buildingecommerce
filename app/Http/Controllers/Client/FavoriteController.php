<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\HousingFavorite;
use App\Models\Project;
use App\Models\ProjectFavorite;
use App\Models\ProjectHousing;
use App\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addProjectHousingToFavorites($id, HttpRequest $request)
    {
        $user = User::where("id", Auth::user()->id)->first();
        $housing = ProjectHousing::where("room_order", $id)->where("project_id", $request->input("project_id"))->get();

        // Kullanıcının favorileri içinde bu konut zaten var mı kontrol et
        $existingFavorite = ProjectFavorite::where('user_id', $user->id)
            ->where('housing_id', $id)
            ->where("project_id", $request->input("project_id"))
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            $message = "Konut favorilerden kaldırıldı";
            $status = "removed";
        } else {
            ProjectFavorite::create([
                "user_id" => $user->id,
                'housing_id' => $id,
                "project_id" => $request->input("project_id"),
            ]);
            $message = "Konut favorilere eklendi.";
            $status = "added";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function addProjectToFavorites($id)
    {
        $user = User::where("id", Auth::user()->id)->first();
        $project = Project::findOrFail($id);

        if (!$user->projects()->where('project_id', $project->id)->exists()) {
            $user->projects()->attach($project);
        }

        return redirect()->back()->with('success', 'Proje favorilere eklendi.');
    }
    public function addHousingToFavorites($id)
    {
        $user = User::where("id", Auth::user()->id)->first();
        $housing = Housing::findOrFail($id);

        // Kullanıcının favorileri içinde bu konut zaten var mı kontrol et
        $existingFavorite = HousingFavorite::where('user_id', $user->id)
            ->where('housing_id', $housing->id)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            $message = "Konut favorilerden kaldırıldı";
            $status = "removed";
        } else {
            HousingFavorite::create([
                "user_id" => $user->id,
                'housing_id' => $housing->id,
            ]);
            $message = "Konut favorilere eklendi.";
            $status = "added";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function showFavorites()
    {
        $user = User::where("id", Auth::user()->id)->with("housingFavorites.housing", 'housingFavorites.housing.city', 'housingFavorites.housing.brand')->first();
        $favorites = $user->housingFavorites;
        $projectFavorites = ProjectFavorite::where("user_id", Auth::user()->id)->with('project.roomInfo', 'projectHousing')->get();
        return view('client.favorites.index', compact('user', 'favorites', 'projectFavorites'));
    }

    public function getHousingFavoriteStatus($id)
    {
        $user = User::where("id", Auth::user()->id)->with("housingFavorites")->first();
        $housing = Housing::findOrFail($id);

        $isFavorite = $user->housingFavorites->contains('housing_id', $housing->id);

        return response()->json([
            'is_favorite' => $isFavorite,
        ]);
    }

    public function getProjectHousingFavoriteStatus($id, $projectId)
    {
        // Kullanıcının favori konutlarını ve projeyi sorgula
        $user = User::where("id", Auth::user()->id)->first();
        $housing = ProjectFavorite::where("user_id", $user->id)
            ->where("housing_id", $id)
            ->where("project_id", $projectId)
            ->first();

        // $housing değişkeni, veritabanında bu konutun favori olup olmadığını içerir
        $isFavorite = $housing !== null;

        return response()->json([
            'is_favorite' => $isFavorite,
        ]);
    }

}
