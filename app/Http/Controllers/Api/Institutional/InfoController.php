<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentNotification;

class InfoController extends Controller
{
    public function destroyAll()
    {
        // Giriş yapmış kullanıcının ID'sini alın
        $userId = auth()->guard()->user()->id;

        // Kullanıcının bildirimlerini silin
        $deleted = DocumentNotification::where('owner_id', $userId)->delete();

        if ($deleted) {
            return response()->json([
                'message' => 'Tüm bildirimler başarıyla silindi.',
                'deleted_count' => $deleted
            ], 200);
        } else {
            return response()->json([
                'message' => 'Silinecek bildirim bulunamadı.'
            ], 404);
        }
    }

    public function notificationDestroyById(Request $request)
        {
            $userId = $request->userId;
            $notificationId = $request->id;
            
            $deleted = DocumentNotification::where('owner_id', $userId)
                ->where('id', $notificationId)
                ->delete(); 
            
            if ($deleted > 0) {
                return response()->json([
                    'message' => 'Bildirim başarıyla silindi.',
                    'deleted_count' => $deleted
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Silinecek bildirim bulunamadı.'
                ], 200);
            }
        }

}
