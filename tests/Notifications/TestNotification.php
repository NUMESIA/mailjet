<?php

namespace Numesia\Mailjet\Test\Notifications;

use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    /**
     * Get Mailjet representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Numesia\Mailjet\MailjetMessage|string
     */
    public function toMailjet($notifiable)
    {
        return 'Content';
    }
}
