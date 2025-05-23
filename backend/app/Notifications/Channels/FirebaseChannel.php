<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Exception\Messaging\NotFound as FirebaseNotFound;

class FirebaseChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (! $token = $notifiable->fcm_token) {
            \Log::warning("User {$notifiable->id} has no FCM token.");
            return;
        }

        $message = $notification->toFirebase($notifiable);

        if (! $message instanceof CloudMessage) {
            \Log::error('toFirebase() did not return a CloudMessage instance.');
            return;
        }

        try {
            \Log::info("Sending FCM to user {$notifiable->id}", ['token' => $token]);
            Firebase::messaging()->send($message);
            \Log::info("FCM sent successfully to user {$notifiable->id}");
        } catch (FirebaseNotFound $e) {
            \Log::error("FCM NotFound (invalid token or wrong project)", [
                'userId'    => $notifiable->id,
                'token'     => $token,
                'exception' => $e->getMessage(),
            ]);
        } catch (\Throwable $e) {
            \Log::error("FCM send failed", [
                'userId'    => $notifiable->id,
                'exception' => $e->getMessage(),
            ]);
        }
    }
}
