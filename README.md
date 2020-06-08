# ISMS (SSLCARE) notifications channel for Laravel

[![Latest Stable Version](https://poser.pugx.org/dgvai/laravel-notification-channel-isms/v/stable)](https://packagist.org/packages/dgvai/laravel-notification-channel-isms)
[![Total Downloads](https://poser.pugx.org/dgvai/laravel-notification-channel-isms/downloads)](https://packagist.org/packages/dgvai/laravel-notification-channel-isms)
[![Latest Unstable Version](https://poser.pugx.org/dgvai/laravel-notification-channel-isms/v/unstable)](https://packagist.org/packages/dgvai/laravel-notification-channel-isms)
[![License](https://poser.pugx.org/dgvai/laravel-notification-channel-isms/license)](https://packagist.org/packages/dgvai/laravel-notification-channel-isms)
[![Monthly Downloads](https://poser.pugx.org/dgvai/laravel-notification-channel-isms/d/monthly)](https://packagist.org/packages/dgvai/laravel-notification-channel-isms)
[![Daily Downloads](https://poser.pugx.org/dgvai/laravel-notification-channel-isms/d/daily)](https://packagist.org/packages/dgvai/laravel-notification-channel-isms)
[![composer.lock](https://poser.pugx.org/dgvai/laravel-notification-channel-isms/composerlock)](https://packagist.org/packages/dgvai/laravel-notification-channel-isms)

This package makes it easy to send sms via [ISMS](https://isms.sslwireless.com) bulk SMS Service (Bangladesh) from SSL Wireless Company, with Laravel 5.5+, 6.x and 7.x.

## Contents

- [Installation](#installation)
	- [Setting up your ISMS in configuration](#setting-up-your-configuration)
- [Usage](#usage)
- [Changelog](#changelog)
- [License](#license)

## Installation

You can install the package via composer:

``` bash
composer require dgvai/laravel-notification-channel-isms
```

### Setting up your configuration

Add your ISMS Account credentials to your `config/services.php`:

```php
// config/services.php
...
'isms' => [
    'token'         =>  env('ISMS_TOKEN'),     // The API-TOKEN generated from ISMS panel
    'sid'           =>  env('ISMS_SID'),       // The SID of your stakeholder
],
...
```

In order to let your Notification know which phone are you sending to, the channel will look for the `mobile_number` attribute of the Notifiable model (eg. User model). If you want to override this behaviour, add the `routeNotificationForISMS` method to your Notifiable model.

```php
public function routeNotificationForISMS()
{
    return '+1234567890';
}
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php

use DGvai\ISMS\ISMS;
use DGvai\ISMS\ISMSChannel;
use Illuminate\Notifications\Notification;

class OrderPlaced extends Notification
{
    public function via($notifiable)
    {
        return [ISMSChannel::class];
    }

    public function toISMS($notifiable)
    {
        return new ISMS('Your order has been placed!');
    }
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
