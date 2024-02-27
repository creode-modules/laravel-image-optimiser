<?php

namespace Modules\ImageOptimiser\app\Concerns;

use Illuminate\Http\Response;
use Modules\ImageOptimiser\app\Presets\Preset;

/**
 * Main interface for the ImageOptimiser module.
 */
interface OptimiserInterface
{
    /**
     * Optimises the Image.
     *
     * @param string $imageUrl The URL of the image to optimise.
     * @param Preset $preset The preset to use for optimisation.
     *
     * @throws \Modules\ImageOptimiser\app\Exceptions\CannotProcessImageException
     *
     * @return \Illuminate\Http\Response
     */
    public function optimise(string $imageUrl, Preset $preset): Response;
}
