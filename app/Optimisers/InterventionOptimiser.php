<?php

namespace Modules\ImageOptimiser\app\Optimisers;

use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;
use Modules\ImageOptimiser\app\Presets\Preset;
use Modules\ImageOptimiser\app\Concerns\OptimiserInterface;

class InterventionOptimiser implements OptimiserInterface
{
    /**
     * The location of the image to optimise.
     *
     * @var string
     */
    protected $imageLocation;

    /**
     * The preset to use for optimisation.
     *
     * @var \Modules\ImageOptimiser\app\Presets\Preset
     */
    protected $preset;

    /**
     * Optimises the Image.
     *
     * @param string $imageLocation The URL or relative location of the image to optimise.
     * @param \Modules\ImageOptimiser\app\Presets\Preset $preset The preset to use for optimisation.
     *
     * @return \Illuminate\Http\Response The URL of the optimised image.
     */
    public function optimise(string $imageLocation, Preset $preset): Response
    {
        $imageLocation = $this->processLocation($imageLocation);

        return Image::cache(
            function ($image) use ($imageLocation, $preset) {
                $this->generateImage($image, $imageLocation, $preset);
            },
            config('image-optimiser.cache_lifetime'),
            true
        )->response('jpg', $preset->quality);
    }

    /**
     * Main function for generating an image with Intervention.
     *
     * @param mixed $image
     * @param string $imageLocation
     * @param Preset $preset
     *
     * @return void
     */
    private function generateImage(&$image, string $imageLocation, Preset $preset): void
    {
        // Make the image from the url.
        $image->make($imageLocation);
        if ($preset->height || $preset->width) {
            $image->resize($preset->width, $preset->height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
    }

    /**
     * Does any required processing on the url/location before formatting it.
     *
     * @param string $imageLocation
     *
     * @return string The processed image location.
     */
    private function processLocation(string $imageLocation): string
    {
        // If first character is a /, remove it. This / is often added by Laravel.
        if (substr($imageLocation, 0, 1) === '/') {
            $imageLocation = substr($imageLocation, 1);
        }

        return $imageLocation;
    }
}
