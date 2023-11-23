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
     */
    public function __construct(
        public readonly ?int $width,
        public readonly ?int $height,
        public readonly ?int $quality
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
            $presetConfig['quality'] ?? null
        );
    }
}
