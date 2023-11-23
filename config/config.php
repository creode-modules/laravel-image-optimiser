<?php

const ONE_YEAR = 60 * 24 * 365;

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
    | Cache Lifetime
    |--------------------------------------------------------------------------
    |
    | How long the optimised images should be cached for (in minutes).
    |
    */
    'cache_lifetime' => ONE_YEAR,
];
