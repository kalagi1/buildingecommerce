<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GoogleSheetsController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $data = $request->json()->all();
        Log::info('Webhook data received:', $data);

        // İlk satırı atlamak için sayaç kullanın
        $rowCount = 0;
        foreach ($data as $row) {
            $rowCount++;
            if ($rowCount == 1) {
                // İlk satırı atla
                Log::info('Skipping first row:', $row);
                continue;
            }

            Log::info('Processing row:', $row);

            $entryData = [
                'name'         => $row[12],
                'email'        => $row[14],
                'phone'        => $row[13],
                'project_name' => $row[7],
                'platform'     => $row[11],
                'province'     => $row[15],
                'job_title'    => $row[16],
                'created_at'   => now()
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
                $userId = $existingUser->id;
                Log::info('Updated existing user with ID: ' . $userId);
            } else {
                // Yeni bir kayıt ekle ve ID'yi al
                $userId = DB::table('assigned_users')
                    ->insertGetId($entryData);
                Log::info('Inserted new user with ID: ' . $userId);
            }

            // project_name değerini projects tablosundaki project_title değeri ile eşleştir
            $project = DB::table('projects')
                ->where('project_title', $row[7])
                ->first();

            if ($project) {
                $projectId = $project->id;
                Log::info('Found project with ID: ' . $projectId);

                // project_assignment tablosundaki project_id değeri hangi user_id ile eşleşirse
                $projectAssignment = DB::table('project_assigment')
                    ->where('project_id', $projectId)
                    ->first();

                if ($projectAssignment) {
                    $danismanId = $projectAssignment->user_id;
                    Log::info('Found project assignment with danisman_id: ' . $danismanId);

                    // assigned_users tablosundaki danisman_id değerini güncelle
                    DB::table('assigned_users')
                        ->where('id', $userId)
                        ->update(['danisman_id' => $danismanId]);
                    Log::info('Updated user with ID: ' . $userId . ' to have danisman_id: ' . $danismanId);
                } else {
                    Log::warning('No project assignment found for project ID: ' . $projectId);
                }
            } else {
                Log::warning('No project found with title: ' . $row[7]);
            }
        }

        return response()->json(['status' => 'success']);
    }
}
