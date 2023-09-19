<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Housing;
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

        if (!$user->housings()->where('housing_id', $housing->id)->exists()) {
            $user->housings()->attach($housing);
        }

        return redirect()->back()->with('success', 'Konut favorilere eklendi.');
    }

    public function showFavorites()
    {
        $user = User::where("id", Auth::user()->id)->first();
        $user->load('projects', 'housings'); 

        return view('favorites.index', compact('user'));
    }
}
