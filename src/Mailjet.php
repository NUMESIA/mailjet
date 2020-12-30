<?php

namespace Numesia\Mailjet;

use Exception;
use Mailjet as MailjetBase;
use Mailjet\Resources;
use Psr\Http\Message\ResponseInterface;
use Mailjet\Response;

class Mailjet
{
    /**
     * Send the email.
     *
     * @param  string  $to
     * @param  array  $data
     * @param  string|null  $sender
     * @return \Mailjet\Response|null
     */
    public function sendEmail(string $to, array $data)
    {
        $response = MailjetBase::post(Resources::$Email, $this->formatRequest($to, $data));

        return $response->getStatus() === 200
        ? $this->checkResponseAndReturn($response)
        : true;
    }

    protected function checkResponseAndReturn(Response $response)
    {
        $content = $response->getBody();

        $messageId = data_get($content, 'Sent.0.MessageID');

        $success = true;

        try {
            $response = MailjetBase::get(Resources::$Message, ["id" => $messageId]);
        } catch (Exception $e) {
            $success = "The message $messageId wasn't sent, please check mailjet website";
        }

        return $success;
    }

    /**
     * Get the form params.
     *
     * @param  string  $to
     * @param  array  $data
     * @param  string|null  $sender
     * @return array
     */
    protected function formatRequest(string $to, array $data): array
    {
        $body = [
            'FromEmail'  => data_get($data, "sender") ?: env('MAIL_FROM_ADDRESS'),
            'FromName'   => data_get($data, "name") ?: env('MAIL_FROM_NAME'),
            'Subject'    => data_get($data, "subject"),
            'Html-part'  => data_get($data, "content"),
            'Recipients' => [['Email' => $to]],
        ];

        return [
            "body" => $body,
        ];
    }
}
