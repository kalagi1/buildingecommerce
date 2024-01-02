<?php

namespace App\Http\Controllers;

use App\Notifications\CustomNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function sendNotification()
    {
        $user = auth()->user();

        Notification::send($user, new CustomNotification);

        return response()->json(['message' => 'Notification sent successfully']);
    }
}
