<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;

/**
 * Admin > Messaging > Notifications ("Web" type) sent to selected users.
 */
class SystemNotification extends Notification
{
    public function __construct(public string $subject, public string $message, public User $sender) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'subject' => $this->subject,
            'message' => $this->message,
            'type' => 'Web',
            'sender_id' => $this->sender->id,
            'sender' => $this->sender->name,
        ];
    }
}
