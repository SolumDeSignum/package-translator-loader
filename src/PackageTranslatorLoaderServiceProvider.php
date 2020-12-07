<?php

declare(strict_types=1);

namespace SolumDeSignum\PackageTranslatorLoader;

use Illuminate\Support\ServiceProvider;

class PackageTranslatorLoaderServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'solumdesignum');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'solumdesignum');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

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
        $this->mergeConfigFrom(__DIR__.'/../config/package-translator-loader.php', 'package-translator-loader');

        // Register the service the package provides.
        $this->app->singleton('package-translator-loader', function ($app) {
            return new PackageTranslatorLoader;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
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
            __DIR__.'/../config/package-translator-loader.php' => config_path('package-translator-loader.php'),
        ], 'package-translator-loader.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/solumdesignum'),
        ], 'package-translator-loader.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/solumdesignum'),
        ], 'package-translator-loader.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/solumdesignum'),
        ], 'package-translator-loader.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
