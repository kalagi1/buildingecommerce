<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(){
        return view('admin.menu_management.index');
    }

    public function getMenu(){
        $menuItems = Menu::getMenuItems();
        return $menuItems;
    }

    public function saveMenu(Request $request){
        Menu::truncate();
        $menuData = $request->input('data');

        // Verileri işlemek için özelleştirilmiş bir fonksiyon
        function processMenuItem($menuItem, $parentId = null) {
            $text = $menuItem['text'];
            $href = $menuItem['href'];
            $target = $menuItem['target'];

            // Menu modelini oluştur
            $createdMenu = Menu::create([
                'parent_id' => $parentId,
                'text' => $text,
                'href' => $href,
                'target' => $target,
                // Diğer sütunları buradan ekle
            ]);

            if (isset($menuItem['children']) && is_array($menuItem['children'])) {
                foreach ($menuItem['children'] as $child) {
                    processMenuItem($child, $createdMenu->id); // parent_id'yi geçiyoruz
                }
            }
        }

        foreach ($menuData as $menuItem) {
            processMenuItem($menuItem);
        }

        return response()->json(['message' => 'Veriler başarıyla kaydedildi']);
    }
}
