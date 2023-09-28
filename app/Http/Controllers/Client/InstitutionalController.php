<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstitutionalController extends Controller
{
    public function profile($slug)
    {

        $users = User::all();
        foreach ($users as $institutional) {
            $slugName = Str::slug($institutional->name);
            if ($slugName === $slug) {
                $institutional = User::where("id", $institutional->id)->with('projects.housings', 'housings', 'city', 'brands')->first();
                return view("client.institutional.detail", compact("institutional"));
            }
        }

    }

    public function projectDetails($slug)
    {
        $users = User::all();
        foreach ($users as $institutional) {
            $slugName = Str::slug($institutional->name);
            if ($slugName === $slug) {
                $institutional = User::where("id", $institutional->id)->with('projects.housings', 'housings', 'city', 'brands')->first();
                return view("client.institutional.project-detail", compact("institutional"));
            }
        }
    }

    public function search(Request $request)
    {
        return $request->all();
        $query = $request->input('q');
        $brand = $request->input('brand');
        return $query;

        // Arama sorgularını işleyin ve sonuçları alın
        // Örneğin, mağaza adı veya markaya göre filtreleme yapabilirsiniz

        // Sonuçları görünüme aktarın ve görünümü döndürün
        return view('client.search_results', compact('results'));
    }

}
