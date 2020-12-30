<?php

namespace Numesia\Mailjet;

use Exception;
use Mailjet as MailjetBase;
use Mailjet\Resources;
use Psr\Http\Message\ResponseInterface;

class Mailjet
{
    /**
     * Send the email.
     *
     * @param  string  $to
     * @param  array  $data
     * @param  string|null  $sender
     * @return \Psr\Http\Message\ResponseInterface|null
     */
    public function sendEmail(string $to, array $data):  ? ResponseInterface
    {
        $response = MailjetBase::post(Resources::$Email, $this->formatRequest($to, $data));

        return $response->getStatusCode() === 200
        ? $this->checkResponseAndReturn($response)
        : $response;
    }

    protected function checkResponseAndReturn(ResponseInterface $response) : ResponseInterface
    {
        $content = json_decode($response->getBody()->getContents());

        $messageId = data_get($content, 'Sent.0.MessageID');

        $error = null;

        try {
            $response = MailjetBase::get(Mailjet\Resources::$Message, ["id" => $messageId]);
        } catch (Exception $e) {
            $error = "The message $messageId wasn't sent, please check mailjet website";
        }

        return !$error
        ? $response
        : $response->withStatus(400, $error);
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
