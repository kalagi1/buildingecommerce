<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\HousingStatus;
use App\Models\Menu;
use App\Models\Project;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getMenuList(){

        $menuList = Menu::all();

        return response()->json($menuList);
    }//End
}
