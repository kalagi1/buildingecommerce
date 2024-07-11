<?php

namespace App\Http\Controllers\Api\Institutional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HousingFavorite;

class HousingController extends Controller
{
    public function destroyAllFavorite()
    {
        // Giriş yapmış kullanıcının ID'sini alın
        $userId = auth()->guard()->user()->id;

        // Kullanıcının favorilerini silin
        $deleted = HousingFavorite::where('user_id', $userId)->delete();

        if ($deleted) {
            return response()->json([
                'message' => 'Tüm favoriler başarıyla silindi.',
                'deleted_count' => $deleted
            ], 200);
        } else {
            return response()->json([
                'message' => 'Silinecek favori bulunamadı.'
            ], 404);
        }
    }
}
