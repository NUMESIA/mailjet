<?php

namespace Numesia\Mailjet;

use Illuminate\Notifications\Notification;
use Numesia\Mailjet\Exceptions\CouldNotSendNotification;

class MailjetChannel
{
    /** @var \Numesia\Mailjet\Mailjet */
    protected $client;

    /**
     * Create a new MailjetChannel instance.
     *
     * @param  \Numesia\Mailjet\Mailjet  $client
     */
    public function __construct(Mailjet $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     *
     * @throws \Numesia\Mailjet\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('mailjet', $notification)) {
            return;
        }

        $message = $notification->toMailjet($notifiable);

        $response = $this->client->sendEmail($to, $message->toArray());

        if ($response->getStatus() !== 200) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }
    }
}
