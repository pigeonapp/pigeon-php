<h1 align="center">Pigeon</h1>

<p align="center">Pigeon lets you easily manage your outbound email, push notifications and SMS. Visit https://pigeonapp.io for more details.</p>


## Installation

The recommended way to install Pigeon is through Composer.

```shell
$ composer require pigeon/pigeon
```

## Usage

```php
$pigeon = new Pigeon\Client('PIGEON_PUBLIC_KEY', 'PIGEON_PRIVATE_KEY');
```
Public (`PIGEON_PUBLIC_KEY`) and private (`PIGEON_PRIVATE_KEY`) keys would be retrieved from the env variables if not passed.

### Prepare for the delivery
```php
$message_identifier = 'message-identifier';
$parcels = ['to' => 'john@example.com'];
```
- Message identifier is used to identify the message. Grab this from your Pigeon dashboard.
- Parcels array accepts `to`, `cc`, `bcc` and `data`.

### Deliver
```php
$pigeon->deliver($message_identifier, $parcels);
```

### Parcel sample
```php
$parcels = [
  'to' => 'John Doe <john@example.com>',
  'cc' => [
    'admin@example.com',
    'Sales Team <sales@example.com>'
  ],
  'data' => [
    // message placeholder values are added here
    'greeting' => 'Hello John!'
  ]
];
```

## Framework integration

- [Laravel](https://github.com/pigeonapp/pigeon-laravel)

## Contributing

You can contribute in one of two ways:

1. File bug reports using the [issue tracker](https://github.com/pigeonapp/pigeon-php/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/pigeonapp/pigeon-php/issues).

This project is intended to be a safe, welcoming space for collaboration, and contributors are expected to adhere to the [Contributor Covenant](http://contributor-covenant.org) code of conduct.

## License

The composer package is available as open source under the terms of the [MIT License](https://opensource.org/licenses/MIT).

## Code of Conduct

Everyone interacting in the Pigeon project’s codebases, issue trackers, chat rooms and mailing lists is expected to follow the [code of conduct](https://github.com/pigeonapp/pigeon-php/blob/master/CODE_OF_CONDUCT.md).
