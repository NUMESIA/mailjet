<?php

namespace Numesia\Mailjet\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($error)
    {
        return new static('Mailjet responded with an error: `' . $error . '`');
    }
}
