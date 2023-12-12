<?php

$oneYear = 60 * 24 * 365;

return [
    /*
    |--------------------------------------------------------------------------
    | Class
    |--------------------------------------------------------------------------
    |
    | The default class to be used for optimisation.
    |
    */
    'class' => \Modules\ImageOptimiser\app\Optimisers\InterventionOptimiser::class,

    /*
    |--------------------------------------------------------------------------
    | Driver Class
    |--------------------------------------------------------------------------
    |
    | The class to be used with Intervention image as a driver.
    |
    | Intervention\Image\Drivers\Gd\Driver::class
    | Intervention\Image\Drivers\Imagick\Driver
    | Intervention\Image\Interfaces\DriverInterface
    |
    */
    'driver_class' => Intervention\Image\Drivers\Gd\Driver::class,

    /*
    |--------------------------------------------------------------------------
    | Presets
    |--------------------------------------------------------------------------
    |
    | The presets and image sizes to be used for optimisation.
    |
    */
    'presets' => [
        'thumbnail' => [
            'width' => 150,
            'height' => null,
            'quality' => 100,
        ],
        'medium' => [
            'width' => 300,
            'height' => null,
            'quality' => 90,
        ],
        'large' => [
            'width' => 1024,
            'height' => null,
            'quality' => 80,
        ],
        'full' => [
            'width' => null,
            'height' => null,
            'quality' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Locations
    |--------------------------------------------------------------------------
    |
    | The base locations that are allowed to be optimised. This could either
    | be a URL or a relative path.
    |
    */
    'allowed_locations' => [
        '/storage', // Default Public Location for Laravel.
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Driver
    |--------------------------------------------------------------------------
    |
    | Cache Driver to be used when caching the optimised images. If null, the
    | default cache driver will be used.
    |
    */
    'cache_driver' => null,

    /*
    |--------------------------------------------------------------------------
    | Cache Lifetime
    |--------------------------------------------------------------------------
    |
    | How long the optimised images should be cached for (in minutes).
    |
    */
    'cache_lifetime' => $oneYear,
];
