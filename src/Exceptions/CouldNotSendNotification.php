<?php

namespace Numesia\Mailjet\Exceptions;

use Psr\Http\Message\ResponseInterface;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError(ResponseInterface $response)
    {
        return new static('Mailjet responded with an error: `'.$response->getReasonPhrase().'`');
    }
}
