<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $menu = Menu::getMenuItems();
        return view('client.home.index',compact('menu'));
    }
}
