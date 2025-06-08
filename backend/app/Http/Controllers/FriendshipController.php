<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    public function getFriends($id)
    {
        $user = User::with('friends', 'pendingFriends')->where('id', $id)->first();
        return response()->json([
            'user' => $user
        ]);
    }

    public function sendRequest($id)
    {
        $user = User::find($id);
        if (auth()->id() === $user->id) {
            return response()->json([
                'error' => 'You cannot send a friend request to yourself'
            ], 400);
        }

        Friendship::updateOrCreate([
            'sender_id' => auth()->id(),
            'recipient_id' => $user->id,
            'status' => 'pending'
        ]);

        Friendship::updateOrCreate([
            'sender_id' => $user->id,
            'recipient_id' => auth()->id(),
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Friend request sent'
        ]);
    }

    public function acceptRequest($id)
    {
        $user = User::find($id);
        $friendship1 = Friendship::where([
            ['sender_id', $user->id],
            ['recipient_id', auth()->id()],
            ['status', 'pending']
        ])->firstOrFail();

        $friendship1->update(['status' => 'accepted']);

        $friendship2 = Friendship::where([
            ['sender_id', auth()->id()],
            ['recipient_id', $user->id],
            ['status', 'pending']
        ])->firstOrFail();

        $friendship2->update(['status' => 'accepted']);

        return back()->with('success', 'Friend request accepted');
    }

    public function rejectRequest($id)
    {
        $user = User::find($id);
        $friendship = Friendship::where([
            ['sender_id', $user->id],
            ['recipient_id', auth()->id()],
            ['status', 'pending']
        ])->firstOrFail();

        $friendship->update(['status' => 'rejected']);

        return back()->with('success', 'Friend request rejected');
    }

    public function removeFriend($id)
    {
        $user = User::find($id);
        $friendship = Friendship::where([
            ['sender_id', auth()->id()],
            ['recipient_id', $user->id]
        ])->orWhere([
            ['sender_id', $user->id],
            ['recipient_id', auth()->id()]
        ])->firstOrFail();

        $friendship->delete();

        return back()->with('success', 'Friend removed');
    }

    public function checkStatus($id)
    {
        $friendship = Friendship::where([
            ['sender_id', auth()->id()],
            ['recipient_id', $id]
        ])->orWhere([
            ['sender_id', $id],
            ['recipient_id', auth()->id()]
        ])->first();
        if (!$friendship) {
            return response()->json([
                'data' => [
                    'status' => null
                ]
            ]);
        }
        if ($friendship->status == 'pending') {
            return response()->json([
                'data' => [
                    'status' => 'pending'
                ]
            ]);
        } else if ($friendship->status == 'friends') {
            return response()->json([
                'data' => [
                    'status' => 'friends'
                ]
            ]);
        } else {
            return response()->json([
                'data' => [
                    'status' => null
                ]
            ]);
        }
    }
}
