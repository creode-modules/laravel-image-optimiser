<?php

namespace Modules\ImageOptimiser\app\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method optimise(string $imageUrl, Preset $preset): string
 */
class Optimiser extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'optimiser';
    }
}
