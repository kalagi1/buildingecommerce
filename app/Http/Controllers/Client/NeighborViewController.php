<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\NeighborView;
use Illuminate\Http\Request;

class NeighborViewController extends Controller {
    public function store(Request $request) {
        $userId = $request->input('user_id');
        $orderId = $request->input('order_id');

        // user_id ve order_id'ye göre veritabanında kayıt var mı kontrol et
        $existingRecord = NeighborView::where('user_id', $userId)
            ->where('order_id', $orderId)
            ->first();

        if (!$existingRecord) {
            // Kayıt yoksa yeni kayıt oluştur
            NeighborView::create([
                'user_id' => $userId,
                'order_id' => $orderId,
                'status' => $request->input('status'),
                'key' => $request->input('key'),
                'amount' => $request->input('amount'),
            ]);

            return response()->json(['success' => true, 'message' => 'Successfully saved.'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Record already exists.'], 400);
        }
    }
}
