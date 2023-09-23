<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;

class InstitutionalController extends Controller
{
    public function profile($slug)
    {

        $users = User::all();
        foreach ($users as $institutional) {
            $slugName = Str::slug($institutional->name);
            if ($slugName === $slug) {
                $institutional = User::where("id", $institutional->id)->with('projects.housings', 'housings', 'city')->first();
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
                $institutional = User::where("id", $institutional->id)->with('projects.housings', 'housings', 'city')->first();
                return view("client.institutional.project-detail", compact("institutional"));
            }
        }
    }
}
