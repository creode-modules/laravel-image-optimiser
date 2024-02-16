<?php

namespace Modules\ImageOptimiser\app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Modules\ImageOptimiser\app\Facades\Optimiser;
use Modules\ImageOptimiser\app\Presets\PresetLoader;
use Modules\ImageOptimiser\app\Exceptions\PresetNotFoundException;

class OptimiseController extends Controller
{
    /**
     * Constructor for Class.
     *
     * @param PresetLoader $presetLoader
     */
    public function __construct(protected PresetLoader $presetLoader)
    {
    }

    /**
     * Optimises the image.
     *
     * @param Request $request The request object.
     * @param string $preset The preset to use for optimisation.
     *
     * @return \Illuminate\Http\Response
     */
    public function optimise(Request $request, $preset)
    {
        // Add preset to request so it can be validated.
        $request->merge(['preset' => $request->route('preset')]);

        // Validate the request to ensure it only allows specific options.
        $urlKey = 'url';
        try {
            $data = $request->validate([
                $urlKey => [
                    'required',
                    'string',
                    // 'url',
                    'starts_with:'.implode(',', config('image-optimiser.allowed_locations', [
                        URL::to('/'),
                    ])),
                ],
                'preset' => [
                    'required',
                    'string',
                    'in:'.implode(',', array_keys(config('image-optimiser.presets'))),
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            abort(404);
        }

        // If the image is an SVG, skip optimising it and just return the original.
        if (pathinfo($data[$urlKey], PATHINFO_EXTENSION) === 'svg') {
            return response(file_get_contents($data[$urlKey]), 200)
                ->header('Content-Type', 'image/svg+xml');
        }

        // Load in the preset for optimisation.
        try {
            $preset = $this->presetLoader->get($data['preset']);
        } catch (PresetNotFoundException $e) {
            abort(404);
        }

        // Return the optimised image in a response.
        return Optimiser::optimise($data[$urlKey], $preset);
    }
}
