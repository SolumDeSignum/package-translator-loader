<?php

declare(strict_types=1);

namespace SolumDeSignum\PackageTranslatorLoader;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PackageTranslatorLoaderServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/package-translator-loader.php',
            'package-translator-loader'
        );

        // Register the service the package provides.
        $this->app->singleton('package-translator-loader', function ($app) {
            return new PackageTranslatorLoader($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['package-translator-loader'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/package-translator-loader.php' => config_path('package-translator-loader.php'),
        ],
            'package-translator-loader.config'
        );
    }
}
