<?php

namespace Numesia\Mailjet;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class MailjetServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('mailjet', function ($app) {
                return $this->app->make(MailjetChannel::class);
            });
        });
    }
}
