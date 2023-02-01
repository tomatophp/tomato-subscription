![Screenshot](https://github.com/tomatophp/tomato-subscription/blob/master/art/screenshot.png)

# Tomato Subscription

Plan subscription with selected features to build a feature control plan for Tomato

## Installation

```bash
composer require tomatophp/tomato-subscription
```

after you install run this command

```bash
php artisan tomato-subscription:install
```

## Using

you can generate a new feature by use this command

```bash
php artisan tomato-feature:generate
```

it will generate a feature for you and you can add it to your plan.

to make some routes guard by our plan feature control:

### Add Model to config

go to `config/tomato-subscription.php` and add new model like

```php
[
    "label" => "Users",
    "id" => \App\Models\User::class
],
```

### Use Subscription trait on your model

you need to add this trait to your model

```php
use TomatoPHP\TomatoSubscription\Traits\HasPlanSubscription;

class User extends Authenticatable
{
    use HasPlanSubscription;
    ...
```

### Add Middleware to your routes

you can add the middleware to you routes like

```php
\TomatoPHP\TomatoSubscription\Http\Middleware\UserHasBeenSubscribedToPlan::class
```

now your app ready to use our package ..

## Support

you can join our discord server to get support [TomatoPHP](https://discord.gg/Xqmt35Uh)

## Docs

you can check docs of this package on [Docs](https://docs.tomatophp.com/tomato-subscription)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [TomatoPHP](mailto:git@queentechsoltions.net)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
