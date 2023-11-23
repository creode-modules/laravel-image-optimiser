<?php

namespace Modules\ImageOptimiser\app\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\ImageOptimiser\app\Optimisers\InterventionOptimiser;

class ImageOptimiserServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'ImageOptimiser';

    protected string $moduleNameLower = 'image-optimiser';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerConfig();
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->singleton('optimiser', function () {
            $className = config('image-optimiser.class');
            return new $className;
        });
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->publishes([__DIR__ . '/../../config/config.php' => config_path($this->moduleNameLower.'.php')], 'image-optimiser-config');
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', $this->moduleNameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
