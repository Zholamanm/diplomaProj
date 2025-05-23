<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);
        // Mark messages as read
        ChatMessage::where('sender_id', $user->id)
            ->where('receiver_id', auth()->id())
            ->where('read', false)
            ->update(['read' => true]);

        $messages = ChatMessage::where(function($query) use ($user) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $user->id);
        })->orWhere(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', auth()->id());
        })->orderBy('created_at', 'asc')->get();

        return response()->json([
            'user' => $user,
            'messages' => $messages
        ]);
    }

    public function sendMessage(Request $request, $id)
    {
        $user = User::find($id);
        $message = ChatMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'message' => $request->message
        ]);

        broadcast(new NewChatMessage($message))->toOthers();

        return response()->json(['status' => 'Message sent']);
    }
}
