# Laravel Image Optimiser

## Installation
Package can be installed on a Laravel Project via composer.

```bash
composer require creode/laravel-image-optimiser
```

## Versions
This package utilises the Intervention Image Library behind the scenes and attempts to keep up to date with it. The following table shows the versions of the package and the versions of the Intervention Image Library that they use.

| Package Version | Intervention Version |
| --------------- | -------------------- |
| 1.0.*           | 2.7.*                |
| 2.0.*           | 3.*                  |

## Configuration
The package can be configured by publishing the config file.

```bash
php artisan vendor:publish --tag="image-optimiser-config"
```
This will create a new file in your config directory called `image-optimiser.php`. This file contains all the configuration options for the package.

## Usage
This package aims to expose a simple route that allows you to optimise images on the fly. The route is `/image/{preset}` and will return the optimised image. The url/path of the image will be passed to the optimiser as a query parameter.

### Rendering the image
In order to render the optimised image inside of a blade template, you can use the following code:

```
{{ route('optimise-image', ['preset' => 'large', 'url' => $media->url]) }}
```

### Caching
In order to save on processing for each image, the package will cache the optimised image. The cache is stored in Laravel's cache system and the lifetime can be configured in the `image-optimiser.php` config file. The cache is stored for 1 year by default. Passing null as the cache lifetime will disable the cache.

## Extending
The package is designed to be extended to allow for different optimisation methods to be created and used. To do this you need to create a new class that implements the `Modules\ImageOptimiser\app\Concerns\OptimiserInterface` interface. This interface has only a single `optimise` method to be implemented.

Once that has been done, you just need to publish configuration for the package and update the `image-optimiser.php` config option to point to your new class.

Alternatively, you can override the `optimiser` service in the `image-optimiser.php` config file and point it to your new class.

```php
$this->app->singleton('optimiser', function () {
    return new MyNewOptimiserClass();
});
```
