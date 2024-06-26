<?php

namespace App\Http\Controllers;

use App\Models\AssignedUser;
use App\Models\User;
use Illuminate\Http\Request;

class GoogleSheetsController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $data = $request->json()->all();

        foreach ($data as $row) {
            AssignedUser::updateOrCreate(
                [
                    'name' => $row[12],
                    'email' => $row[14],
                    'phone' => $row[13], 
                    'project_name' => $row[7], 
                    'platform' => $row[11], 
                    'province' => $row[15], 
                    'job_title' => $row[16], 
                ]
            );
        }

        return response()->json(['status' => 'success']);
    }
}
