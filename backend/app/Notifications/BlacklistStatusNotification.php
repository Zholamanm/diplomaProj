<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

class BlacklistStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $blackList;
    protected $status;

    public function __construct($blackList, $status)
    {
        $this->blackList = $blackList;
        $this->status = $status;
        Log::info("BlacklistStatusNotification::__construct called for BlackList ID={$blackList->id}");
    }

    public function via($notifiable)
    {
        Log::info("BlacklistStatusNotification via() for user ID={$notifiable->id}");
        return ['firebase'];
    }

    public function toFirebase($notifiable)
    {
        $title = 'Black list update!';
        $body = $this->status === 'added'
            ? 'You have been *added* to the blacklist.'
            : 'You have been *removed* from the blacklist.';
        Log::info("toFirebase: title='{$title}', user={$notifiable->id}, token={$notifiable->fcm_token}");

        return CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification(FirebaseNotification::create($title, $body))
            ->withData([
                'blacklist_id' => (string) $this->blackList->id,
                'expire_date'  => $this->blackList->expire_date,
            ]);
    }
}
