<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class BookAvailableNotification extends Notification
{
    use Queueable;

    protected $locationBook;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($locationBook)
    {
        $this->locationBook = $locationBook;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['firebase'];
    }

    public function toFirebase($notifiable): CloudMessage
    {
        $token = $notifiable->fcm_token;

        $title = 'Book Available!';
        $body  = "The book '{$this->locationBook->book->title}' is now available at '{$this->locationBook->location->name}'.";

        return CloudMessage::withTarget('token', $token)
            ->withNotification(FirebaseNotification::create($title, $body))
            ->withData([
                'location_book_id' => (string) $this->locationBook->id,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
