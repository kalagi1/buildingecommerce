<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ApplyNow;
use Illuminate\Http\Request;

class ApplyNowController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'title' => 'required|string|max:255',
            'project_id' => 'required|integer',
        ]);

        ApplyNow::create($request->all());

        return response()->json(['message' => 'Başvurunuz başarıyla gönderildi!'], 200);
    }
}
