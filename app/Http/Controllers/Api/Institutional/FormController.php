<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function swapApplications()
    {
        $apps = Form::with('city', 'county')->where('store_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        if ($apps->isNotEmpty()) {
            // Eğer veri bulunduysa, veriyi dön
            return response()->json($apps, 200);
        }

        // Eğer veri bulunamadıysa, uygun bir mesaj dön
        return response()->json(['message' => 'Not Found.'], 404);
    }

    public function showSwapApplication(Request $request, Form $form)
    {
        return response()->json(["form" => $form]);
    }
}
