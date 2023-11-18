<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportChatController extends Controller
{
    public function userChat()
    {
        return view('client.chat.index');
    }

    public function adminChat()
    {
  
        return view('admin.chat.index');
    }

    public function getChatHistory()
    {
        $receiverId = Auth::user()->id;

        $chatHistory = Message::where('receiver_id', $receiverId)
            ->orWhere('sender_id', $receiverId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($chatHistory);
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Lütfen giriş yapınız.']);
        }

        $data = $request->validate([
            'receiver_id' => 'int',
            'sender_id' => 'int',
            'content' => 'string',
            'chat_id' => 'int',
        ]);

        $user = User::where("id", Auth::user()->id)->first();
        $chat = Chat::where("user_id", $user->id)->first();
        $data['sender_id'] = $user->id;
        $data['receiver_id'] = "4";
        $data['chat_id'] = $chat->id;

        if ($data['receiver_id'] == 4 && $data['sender_id'] == 4) {
            return response()->json(['error' => 'Admin canlı destekle mesajlaşma işlemi yapamaz.']);
        }
        
        $message = Message::create($data);

        if ($this->isFirstMessage($user->id, $data['receiver_id'])) {
            $adminMessageData = [
                'sender_id' => $data['receiver_id'], // Admin
                'receiver_id' => $user->id,
                "chat_id" => $chat->id,
                'content' => 'Mesajınız alındı, en kısa sürede size dönüş yapacağız.',
            ];
            Message::create($adminMessageData);
        }

        return response()->json(['message' => $message]);
    }

    private function isFirstMessage($senderId, $receiverId)
    {
        $messageCount = Message::where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->count();

        return $messageCount == 1;
    }

}
