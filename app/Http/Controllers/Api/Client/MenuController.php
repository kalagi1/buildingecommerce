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
        $formattedMenu = [];
    
        // Parent olmayan menülerin ilk olarak düzenlenmesi
        foreach ($menuList as $menu) {
            if ($menu->parent_id === null) {
                $formattedMenu[$menu->id] = [
                    'id' => $menu->id,
                    'href' => $menu->href,
                    'text' => $menu->text,
                    'target' => $menu->target,
                    'submenus' => $this->getSubmenus($menuList, $menu->id)
                ];
            }
        }
    
        return response()->json(array_values($formattedMenu));
    }
    
    private function getSubmenus($menuList, $parentId) {
        $submenus = [];
    
        foreach ($menuList as $menu) {
            if ($menu->parent_id == $parentId) {
                $submenus[] = [
                    'id' => $menu->id,
                    'href' => $menu->href,
                    'text' => $menu->text,
                    'target' => $menu->target,
                    'parent_id' =>$menu->parent_id,
                    'submenus' => $this->getSubmenus($menuList, $menu->id)
                ];
            }
        }
    
        return $submenus;
    }
    
}
