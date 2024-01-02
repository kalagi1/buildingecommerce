<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $notification = DocumentNotification::find($request->id);
        $notification->update(['readed' => 1]);
        return response()->json(['message' => 'Bildirim görüntülendi']);
    }

}
