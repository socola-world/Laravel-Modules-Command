# Laravel Modules Command

Create Laravel package with structure like laravel application

[//]: # ([![Latest Version on Packagist]&#40;https://img.shields.io/packagist/v/socoladaica/laravel-modules-command.svg?style=flat-square&#41;]&#40;https://packagist.socoladaica.com/packages/socoladaica/laravel-modules-command&#41;)

[//]: # ([![GitHub Tests Action Status]&#40;https://img.shields.io/github/workflow/status/socoladaica/laravel-modules-command/Tests?label=tests&#41;]&#40;https://github.com/socoladaica/laravel-modules-command/actions?query=workflow%3ATests+branch%3Amaster&#41;)

[//]: # ([![Total Downloads]&#40;https://img.shields.io/packagist/dt/socoladaica/laravel-modules-command.svg?style=flat-square&#41;]&#40;https://packagist.socoladaica.com/packages/socoladaica/laravel-modules-command&#41;)

[//]: # ()
[//]: # (Generate Command for Laravel Modules base on laravel Generate Command)

## Installation

You can install the package via composer:

```bash
composer require socoladaica/laravel-modules-command
```

## Usage

### Create new Package

```shell
php artisan cms:make:module <package-name>
```

### Make Model

```shell
php artisan cms:make:model <model name> -mfsc <module>
# Ex
php artisan cms:make:model Admin -mfsc blog-common
```

### Make Controller

```shell
php artisan cms:make:controller <controller name> -mfsc <module>
# Ex blade controller
php artisan cms:make:controller CategoryController --resource blog-api-admin
# Ex resource controller
php artisan cms:make:controller --resource --api --model=App\Models\User CategoryController blog-api-admin
```

See all command []

[//]: # ()
[//]: # (```bash)

[//]: # (php artisan cms:make:module)

[//]: # ()
[//]: # (php artisan cms:make:cast <name> <module>)

[//]: # (php artisan cms:make:channel <name> <module> )

[//]: # (php artisan cms:make:component <name> <module> )

[//]: # (php artisan cms:make:controller <name> <module>)

[//]: # (php artisan cms:make:event <name> <module>)

[//]: # (php artisan cms:make:exception <name> <module> )

[//]: # (php artisan cms:make:factory <name> <module>)

[//]: # (php artisan cms:make:job <name> <module>)

[//]: # (php artisan cms:make:listener <name> <module> )

[//]: # (php artisan cms:make:mail <name> <module>)

[//]: # (php artisan cms:make:middleware <name> <module> )

[//]: # (php artisan cms:make:migration <name> <module>)

[//]: # (php artisan cms:make:model <name> <module>)

[//]: # (php artisan cms:make:notification <name> <module>)

[//]: # (php artisan cms:make:observer <name> <module>)

[//]: # (php artisan cms:make:policy <name> <module>)

[//]: # (php artisan cms:make:provider <name> <module>)

[//]: # (php artisan cms:make:request <name> <module>)

[//]: # (php artisan cms:make:resource <name> <module>)

[//]: # (php artisan cms:make:rule <name> <module>)

[//]: # (php artisan cms:make:seeder <name> <module>)

[//]: # (php artisan cms:make:test <name> <module>)

[//]: # (```)

[//]: # ()
[//]: # (You can use all option like laravel command. Example:)

[//]: # (```bash)

[//]: # (php artisan cms:make:controller <name> --resource <module>)

[//]: # (```)

[//]: # ()
[//]: # (## Publish stub)

[//]: # ()
[//]: # (```bash)

[//]: # (php artisan stub:publish)

[//]: # (```)

[//]: # ()
[//]: # (## Testing)

[//]: # ()
[//]: # (```bash)

[//]: # (composer test)

[//]: # (```)

[//]: # ()
[//]: # (## Load local package)

[//]: # ()
[//]: # (```)

[//]: # (```)

[//]: # ()
[//]: # (## Changelog)

[//]: # ()
[//]: # (Please see [CHANGELOG]&#40;CHANGELOG.md&#41; for more information on what has changed recently.)

[//]: # ()
[//]: # (## Contributing)

[//]: # ()
[//]: # (Please see [CONTRIBUTING]&#40;.github/CONTRIBUTING.md&#41; for details.)

[//]: # ()
[//]: # (## Security Vulnerabilities)

[//]: # ()
[//]: # (Please review [our security policy]&#40;../../security/policy&#41; on how to report security vulnerabilities.)

[//]: # ()
[//]: # (## Credits)

[//]: # ()
[//]: # (- [Socola Dai Ca]&#40;https://github.com/SocolaDaiCa&#41;)

[//]: # (- [All Contributors]&#40;../../contributors&#41;)

[//]: # ()
[//]: # (## License)

[//]: # ()
[//]: # (The MIT License &#40;MIT&#41;. Please see [License File]&#40;LICENSE.md&#41; for more information.)

[//]: # ()
[//]: # (## Reference)

[//]: # ()
[//]: # (- <https://github.com/spatie/package-skeleton-laravel>)

[//]: # (- <https://laravel-news.com/building-your-own-laravel-packages>)

[//]: # (- <https://laravelpackage.com/#reasons-to-develop-a-package>)

## Reference

- <https://laravelpackage.com/#reasons-to-develop-a-package>

[//]: # (3)
