<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (!$notifiable->fcm_token) {
            \Log::warning("User {$notifiable->id} has no FCM token.");
            return;
        }

        $message = $notification->toFirebase($notifiable);

        if ($message) {
            \Log::info("Sending Firebase notification to user {$notifiable->id}");
            Firebase::messaging()->send($message);
        }
    }
}
