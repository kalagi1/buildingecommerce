<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Housing;
use App\Models\HousingFavorite;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
            // Eğer favorilerde varsa, favorilerden kaldır
            $existingFavorite->delete();
            return redirect()->back()->with('success', 'Konut favorilerden kaldırıldı.');
        } else {
            // Eğer favorilerde yoksa, favorilere ekle
            HousingFavorite::create([
                "user_id" => $user->id,
                'housing_id' => $housing->id,
            ]);

            return redirect()->back()->with('success', 'Konut favorilere eklendi.');
        }
    }

    public function showFavorites()
    {
        $user = User::where("id", Auth::user()->id)->with("housingFavorites.housing",'housingFavorites.housing.city','housingFavorites.housing.brand')->first();
        $favorites = $user->housingFavorites;
        return view('client.favorites.index', compact('user', 'favorites'));
    }
}
