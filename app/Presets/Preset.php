<?php

namespace Modules\ImageOptimiser\app\Presets;

class Preset
{
    /**
     * Constructor for Preset class.
     *
     * @param integer|null $width
     * @param integer|null $height
     * @param integer|null $quality
     * @param bool|null $allow_upscaling
     */
    public function __construct(
        public readonly ?int $width,
        public readonly ?int $height,
        public readonly ?int $quality,
        public readonly ?bool $allow_upscaling = false
    )
    {
    }

    /**
     * Parses preset config and returns a preset.
     *
     * @param array $presetConfig
     * @return self
     */
    public static function makeFromConfig(array $presetConfig) {
        return new self(
            $presetConfig['width'] ?? null,
            $presetConfig['height'] ?? null,
            $presetConfig['quality'] ?? null,
            $presetConfig['allow_upscaling'] ?? false,
        );
    }
}
