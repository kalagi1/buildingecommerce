<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller {
    public function getFeaturedSliders() {
        $sliders =  Slider::all();
        return response()->json( $sliders );

    }
}
