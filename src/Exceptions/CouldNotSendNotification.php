<?php

namespace Numesia\Mailjet\Exceptions;

use Mailjet\Response;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError(Response $response)
    {
        return new static('Mailjet responded with an error: `' . $response->getReasonPhrase() . '`');
    }
}
