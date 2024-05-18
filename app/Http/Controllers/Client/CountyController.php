<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\County;
use App\Models\District;
use App\Models\Neighborhood;
use PhpParser\Node\Expr\New_;

class CountyController extends Controller
{
   
    public function getCounties($city)
    {
        $city = City::where('id', $city)->first();
        $counties = District::where('ilce_sehirkey', $city->id)->get();
        $cityName = mb_strtolower($city->title, 'UTF-8');
        $cityName = mb_strtoupper(mb_substr($cityName, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($cityName, 1, null, 'UTF-8');
        function slugify($text)
        {
            // Replace non-letter or digits by -
            $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    
            // Transliterate
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
            // Remove unwanted characters
            $text = preg_replace('~[^-\w]+~', '', $text);
    
            // Trim
            $text = trim($text, '-');
    
            // Remove duplicate -
            $text = preg_replace('~-+~', '-', $text);
    
            // Lowercase
            $text = strtolower($text);
    
            return $text;
        }
        return response()->json([
            'counties' => $counties,
            'cityName' => $city->title,
            "citySlug" => slugify($city->title)
        ]);
    }

    public function getNeighborhood($neighborhood)
    {
       
        $neighborhood = Neighborhood::where("mahalle_id", $neighborhood)->first();
        function slugifys($text)
        {
            // Replace non-letter or digits by -
            $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    
            // Transliterate
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
            // Remove unwanted characters
            $text = preg_replace('~[^-\w]+~', '', $text);
    
            // Trim
            $text = trim($text, '-');
    
            // Remove duplicate -
            $text = preg_replace('~-+~', '-', $text);
    
            // Lowercase
            $text = strtolower($text);
    
            return $text;
        }

        return response()->json([
            'neighborhoodName' => $neighborhood->mahalle_title,
            "neighborhoodSlug" => slugifys($neighborhood->mahalle_title)
        ]);
    }

    public function getCountiesForClient($city)
    {
        $counties = County::where('city_id', $city)->get();
        return response()->json($counties);
    }

    public function getNeighborhoods($county)
    {
        $neighborhoods = Neighborhood::where('mahalle_ilcekey', $county)->get();
        return response()->json($neighborhoods);
    }

    public function getNeighborhoodsForClient($county)
    {
        function slugifyn($text)
        {
            // Replace non-letter or digits by -
            $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    
            // Transliterate
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
            // Remove unwanted characters
            $text = preg_replace('~[^-\w]+~', '', $text);
    
            // Trim
            $text = trim($text, '-');
    
            // Remove duplicate -
            $text = preg_replace('~-+~', '-', $text);
    
            // Lowercase
            $text = strtolower($text);
    
            return $text;
        }
        $county = District::where('ilce_key', $county)->first();
        $countyName = mb_strtolower($county->ilce_title, 'UTF-8');
        $countyName = mb_strtoupper(mb_substr($countyName, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($countyName, 1, null, 'UTF-8');

        $neighborhoods = Neighborhood::where('mahalle_ilcekey', $county->ilce_key)->get();


        return response()->json([
            'neighborhoods' => $neighborhoods,
            'countyName' => $county->ilce_title,
            "countySlug" => slugifyn($county->ilce_title)

        ]);
    }
}
