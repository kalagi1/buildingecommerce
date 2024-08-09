<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProjectHousing;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function store(Request $request)
    {
        // Gelen isteğin doğruluğunu kontrol et
        $validated = $request->validate([
            'project_id' => 'required|integer',
            'project_housing' => 'required|integer',
        ]);

        // Proje ve oda bilgileri ile eşleşen kaydı bul
        $projectHousing = ProjectHousing::where('project_id', $validated['project_id'])
            ->where('room_order', $validated['project_housing'])
            ->where('key', 'Talep Sayısı') // Burada "name[]" yerine "Talep Sayısı" kullanılmalı
            ->first();

        if ($projectHousing) {
            // Eğer kayıt varsa, talep sayısını artır
            $projectHousing->value = ($projectHousing->value ?? 0) + 1;
            $projectHousing->save();
            return response()->json(['success' => true, 'message' => 'Talep başarıyla gönderildi.']);
        } else {
            // Eğer kayıt yoksa yeni bir kayıt oluştur
            ProjectHousing::create([
                'project_id' => $validated['project_id'],
                'room_order' => $validated['project_housing'],
                'key' => 'Talep Sayısı',
                'name' => 'talep_sayisi[]',
                'value' => 1
            ]);

            return response()->json(['success' => true, 'message' => 'Talep başarıyla gönderildi.']);
        }
    }
}
