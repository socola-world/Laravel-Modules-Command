[//]: # ([<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />]&#40;https://supportukrainenow.org&#41;)

# __MODULE_NAMESPACE__\__STUDLY_NAME__

[![Latest Version on Packagist](https://img.shields.io/packagist/v/__VENDOR__/__LOWER_NAME__.svg?style=flat-square)](https://packagist.socoladaica.com/packages/__VENDOR__/__LOWER_NAME__)

[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/__VENDOR__/__LOWER_NAME__/run-tests?label=tests)](https://github.com/__VENDOR__/__LOWER_NAME__/actions?query=workflow%3Arun-tests+branch%3Amain)

[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/__VENDOR__/__LOWER_NAME__/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/__VENDOR__/__LOWER_NAME__/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)

[![Total Downloads](https://img.shields.io/packagist/dt/:__VENDOR__/__LOWER_NAME__.svg?style=flat-square)](https://packagist.socoladaica.com/packages/__VENDOR__/__LOWER_NAME__)

[//]: # (## Support us)

[//]: # ()
[//]: # (We invest a lot of resources into creating [best in class open source packages]&#40;https://spatie.be/open-source&#41;. You can support us by [buying one of our paid products]&#40;https://spatie.be/open-source/support-us&#41;.)


[//]: # (We highly appreciate you sending us a postcard from your hometown, mentioning which of our package&#40;s&#41; you are using. You'll find our address on [our contact page]&#40;https://spatie.be/about-us&#41;. We publish all received postcards on [our virtual postcard wall]&#40;https://spatie.be/open-source/postcards&#41;.)

## Installation

You can install the package via composer:

```bash
composer require __VENDOR__/__LOWER_NAME__
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="__MODULE_NAMESPACE__\__STUDLY_NAME__\__PROVIDER_NAMESPACE__\__STUDLY_NAME__ServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="__MODULE_NAMESPACE__\__STUDLY_NAME__\__PROVIDER_NAMESPACE__\__STUDLY_NAME__ServiceProvider" --tag="config"
```

Optionally, you can publish the views using

```bash
--provider="__MODULE_NAMESPACE__\__STUDLY_NAME__\__PROVIDER_NAMESPACE__\__STUDLY_NAME__ServiceProvider" --tag="views"
```

## Usage

```php
$variable = new VendorName\Skeleton();

echo $variable->echoPhrase('Hello, VendorName!');

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/:author_username/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [:author_name](https://github.com/:author_username)

- [All Contributors](../../contributors)

## License

**__LICENSE__**. Please see [LICENSE File](LICENSE) for more information.
