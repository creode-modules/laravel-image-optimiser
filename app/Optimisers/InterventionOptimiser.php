<?php

namespace Modules\ImageOptimiser\app\Optimisers;

use Illuminate\Http\Response;
use Intervention\Image\EncodedImage;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
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
        $image = $this->getOptimisedImage($imageLocation, $preset);

        return (new \Illuminate\Http\Response($image))->header('Content-Type', 'image/webp');
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

    /**
     * Gets the optimised image from the cache or generates it.
     *
     * @param string $imageLocation
     * @param Preset $preset
     *
     * @return EncodedImage
     */
    private function getOptimisedImage(string $imageLocation, Preset $preset): EncodedImage
    {
        $cache = resolve('image-optimiser-cache');
        $cacheKey = 'image-optimiser-' . md5($imageLocation . implode(',', $preset->toArray()));

        // If the image is not in the cache, generate it.
        if (!$image = $cache::get($cacheKey)) {
            $processedImage = $this->processImage($imageLocation, $preset);
            $cache::put($cacheKey, $processedImage, config('image-optimiser.cache_lifetime'));
            $image = $processedImage;
        }

        return $image;
    }

    /**
     * Main function for generating an image with Intervention.
     *
     * @param string $imageLocation
     * @param Preset $preset
     *
     * @return EncodedImage
     */
    private function processImage(string $imageLocation, Preset $preset): EncodedImage
    {
        $imageManager = new ImageManager(resolve('image-optimiser-driver'));

        // Loads the image from the location.
        $image = $this->loadImage($imageManager, $imageLocation);

        // Scales the image if required.
        if ($preset->height || $preset->width) {
            $image = $image
                ->scale($preset->width, $preset->height);
        }

        // Converts the image to webp.
        return $image->toWebp($preset->quality);
    }

    /**
     * Loads the image from the location.
     *
     * @param ImageManager $imageManager
     * @param string $imageLocation
     *
     * @return ImageInterface
     */
    private function loadImage(ImageManager $imageManager, string $imageLocation): ImageInterface
    {
        // We need to determine if the image is a url or a local file due to how Intervention handles them.
        if (filter_var($imageLocation, FILTER_VALIDATE_URL)) {
            return $imageManager->read(file_get_contents($imageLocation));
        }

        return $imageManager->read($imageLocation);
    }
}
