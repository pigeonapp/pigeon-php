<h1 align="center">Pigeon</h1>

<p align="center">Pigeon lets you easily manage your outbound email, push notifications and SMS. Visit https://pigeonapp.io for more details.</p>


## Installation

The recommended way to install Pigeon is through Composer.

```shell
$ composer require pigeon/pigeon
```

## Usage

Public (`PIGEON_PUBLIC_KEY`) and private (`PIGEON_PRIVATE_KEY`) keys would be retrieved from the env variables if not passed.

```php
$pigeon = new Pigeon('PIGEON_PUBLIC_KEY', 'PIGEON_PRIVATE_KEY');
$pigeon->deliver('message-identifier', ['to' => 'user@example.com']);
```

## Contributing

You can contribute in one of two ways:

1. File bug reports using the [issue tracker](https://github.com/pigeonapp/pigeon-php/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/pigeonapp/pigeon-php/issues).

This project is intended to be a safe, welcoming space for collaboration, and contributors are expected to adhere to the [Contributor Covenant](http://contributor-covenant.org) code of conduct.


_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

The composer package is available as open source under the terms of the [MIT License](https://opensource.org/licenses/MIT).

## Code of Conduct

Everyone interacting in the Pigeon project’s codebases, issue trackers, chat rooms and mailing lists is expected to follow the [code of conduct](https://github.com/pigeonapp/pigeon-php/blob/master/CODE_OF_CONDUCT.md).
