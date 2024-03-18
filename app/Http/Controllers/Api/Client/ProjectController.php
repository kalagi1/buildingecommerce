<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function getFeaturedProjects()
    {
        $featuredProjects = Project::select('projects.*')
        ->with("city", "county",'user',"neighbourhood")
        ->with( 'brand', 'roomInfo','listItemValues', 'housingType')
        ->orderBy("created_at", "desc")
        ->where('projects.status', 1)
        ->get();
        return response()->json($featuredProjects);
    }
}
