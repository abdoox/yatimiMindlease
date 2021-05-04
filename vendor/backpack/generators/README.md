# Backpack Generators

Quickly generate Backpack templated Models, Requests, Views and Config files

## Install

Via Composer

``` bash
$ composer require laravel-backpack/generators
```

Add this to your config/app.php, under "providers":

```php
Backpack\Generators\GeneratorsServiceProvider::class,
```

## Usage

Open the console and enter one of the commands to generate:

- Models (available options: --softdelete)

``` bash
$ php artisan backpack:model
```

- Requests

``` bash
$ php artisan backpack:request
```

- Views (available options: --plain)

``` bash
$ php artisan backpack:view
```

- Config files

``` bash
$ php artisan backpack:config
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Cristian Tone][http://updivision.com]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
