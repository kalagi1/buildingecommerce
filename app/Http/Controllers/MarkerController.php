<?php

namespace App\Http\Controllers;

use App\Models\Housing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class MarkerController extends Controller
{
    public function index()
    {
        // Konutları veritabanından al
        $housings = Housing::with([
            'images',
            'housing_type',
            'listItems',
            'city',
            'district',
            'neighborhood'
        ])
        ->where('status', 1)
        ->whereNull('is_sold')
        ->whereHas('listItems', function ($query) {
            $query->where('item_type', 2);
        })
        ->orderBy('created_at', 'desc')
        ->get();
    
        // İşaretçi verilerini oluştur
        $markers = $housings->map(function ($housing) {
            $housingTypeData = json_decode($housing->housing_type_data);
    
            // Fiyatları belirle
            $price = isset($housingTypeData->price[0]) ? $housingTypeData->price[0] : 0;
            $dailyRent = isset($housingTypeData->daily_rent[0]) ? $housingTypeData->daily_rent[0] : 0;
    
            $finalPrice = $housing->step2_slug == 'gunluk-kiralik' ? $dailyRent : $price;
    
            if ($housing->discount_amount) {
                $finalPrice -= $housing->discount_amount;
            }
    


        // Açıklamayı oluştur
        $desc = '';
        if ($housing->city) {
            $desc .= $housing->city->title;
        }
        if ($housing->district) {
            $desc .= ($desc ? '/ ' : '') . $housing->district->ilce_title;
        }
        if ($housing->neighborhood) {
            $desc .= ($desc ? '/ ' : '') . $housing->neighborhood->mahalle_title;
        }  


            return [
                'id' => 'marker-' . $housing->id,
                'center' => [$housing->latitude, $housing->longitude], // Bu alanın var olduğunu varsayıyorum
                'icon' => "<i class='fa fa-home'></i>",
                'title' => $housing->title, // veya uygun bir başlık
                'desc' => $desc,
                'price' => number_format($finalPrice, 0, ',', '.'),
                'image' => URL::to('/') . '/housing_images/' . json_decode($housing->housing_type_data)->image ,
                'link' =>  route('housing.show', ['housingSlug' => $housing->step1_slug . '-' . $housing->step2_slug . '-' . $housing->slug, 'housingID' => $housing->id + 2000000]) 
            ];
        });
    
        // JSON olarak yanıt döndürme
        return response()->json(['data' => $markers]);
    }
    
}
