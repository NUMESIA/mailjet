<?php

namespace Numesia\Mailjet\Test;

use Illuminate\Notifications\Notifiable;

class TestNotifiable
{
    use Notifiable;

    /**
     * @return string
     */
    public function routeNotificationForMailjet(): string
    {
        return 'email@example.com';
    }
}
