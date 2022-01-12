<?php

namespace Numesia\Mailjet;

use Mailjet as MailjetBase;
use Mailjet\Resources;
use Mailjet\Response;

class Mailjet
{
    /**
     * Send the email.
     *
     * @param  string|array  $to
     * @param  array  $data
     * @param  string|null  $sender
     * @return \Mailjet\Response|null
     */
    public function sendEmail($to, array $data)
    {
        return MailjetBase::post(Resources::$Email, $this->formatRequest($to, $data));
    }

    /**
     * Get the form params.
     *
     * @param  string|array  $to
     * @param  array  $data
     * @param  string|null  $sender
     * @return array
     */
    protected function formatRequest($to, array $data): array
    {
        $to = is_array($to) ? $to : [$to];

        $recipients = array_map(function ($recipient) {
            return [
                'Email' => $recipient,
            ];
        }, $to);

        $body = [
            'FromEmail'   => data_get($data, "sender") ?: env('MAIL_FROM_ADDRESS'),
            'FromName'    => data_get($data, "name") ?: env('MAIL_FROM_NAME'),
            'Subject'     => data_get($data, "subject"),
            'Html-part'   => data_get($data, "content"),
            'Recipients'  => $recipients,
            'Attachments' => data_get($data, "attachments") ?: [],
        ];

        return [
            "body" => $body,
        ];
    }
}
