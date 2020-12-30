# Mailjet notifications channel for Laravel

This package makes it easy to send notifications using Mailjet with Laravel 5.5+, 6.x and 7.x.


## Contents

- [Prerequisite](#prerequisite)
- [Installation](#installation)
- [Usage](#usage)
- [Testing](#testing)

## Prerequisite

Configure https://github.com/mailjet/laravel-mailjet

## Installation

You can install the package via composer:

``` bash
composer require numesia/mailjet
```

Add the Mailjet Provider :

```
'providers' => [
    ...
    Numesia\Mailjet\MailjetServiceProvider::class,
    ...
]
```
## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use Numesia\Mailjet\MailjetChannel;
use Numesia\Mailjet\MailjetMessage;
use Illuminate\Notifications\Notification;

class ProjectCreated extends Notification
{
    public function via($notifiable)
    {
        return [MailjetChannel::class]; // or 'mailjet'
    }

    public function toMailjet($notifiable)
    {
        return (new MailjetMessage)
            ->sender("sender@email.com")
            ->name("Sender Name")
            ->subject("My Subject")
            ->content("My Html Content");
    }
}
```

In order to let your Notification know which email to use, add the `routeNotificationForMailjet` method to your Notifiable model.

This method needs to return an email.

```php
public function routeNotificationForMailjet(Notification $notification)
{
    return $this->email;
}
```

## Testing

``` bash
$ composer test
```
