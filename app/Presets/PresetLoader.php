<?php

namespace Modules\ImageOptimiser\app\Presets;

use Modules\ImageOptimiser\app\Presets\Preset;
use Modules\ImageOptimiser\app\Exceptions\PresetNotFoundException;

class PresetLoader {
    /**
     * Loads presets from config.
     *
     * @throws \Modules\ImageOptimiser\app\Exceptions\PresetNotFoundException
     *
     * @return \Modules\ImageOptimiser\app\Presets\Preset
     */
    public static function get(string $preset): Preset
    {
        $presets = collect(config('image-optimiser.presets'));

        $presetConfig = $presets->first(function ($config, $key) use ($preset) {
            return $key === $preset;
        });

        if (!$presetConfig) {
            throw new PresetNotFoundException('Preset not found');
        }

        return Preset::makeFromConfig($presetConfig);
    }
}
