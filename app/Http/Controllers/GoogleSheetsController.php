<?php

namespace App\Http\Controllers;

use App\Models\AssignedUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoogleSheetsController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $data = $request->json()->all();
    
        foreach ($data as $row) {
            $entryData = [
                'name' => $row[12],
                'email' => $row[14],
                'phone' => $row[13],
                'project_name' => $row[7],
                'platform' => $row[11],
                'province' => $row[15],
                'job_title' => $row[16],
            ];
    
            // Veritabanında mevcut kaydı kontrol et
            $existingUser = DB::table('assigned_users')
                ->where('email', $row[14])
                ->first();
    
            if ($existingUser) {
                // Mevcut kaydı güncelle
                DB::table('assigned_users')
                    ->where('id', $existingUser->id)
                    ->update($entryData);
            } else {
                // Yeni bir kayıt ekle
                DB::table('assigned_users')
                    ->insert($entryData);
            }
        }
    
        return response()->json(['status' => 'success']);
    }
    
}
