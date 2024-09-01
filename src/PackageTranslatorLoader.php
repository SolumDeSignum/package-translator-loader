<?php

declare(strict_types=1);

namespace SolumDeSignum\PackageTranslatorLoader;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PackageTranslatorLoader
{
    public ?string $locale = null;

    public string $translator;

    public function __construct(
        public Application $app,
        public array $config = [
            'translator' => 'package-translation-loader.translator',
            'nameSpace' => 'solumdesignum/package-translation-loader',
            'packageRootPath' => __DIR__ . '/..',
            'loadLangPath' => '/../resources/lang',
            'loaderLangPath' => '/resources/lang',
        ],
        ?string $locale = null
    ) {
        $this->translator = $this->config['translator'];
        $this->localeSetter($locale);
        $this->loadTranslations();
    }

    public function localeSetter(?string $locale): void
    {
        $this->locale = $locale ?? $this->setLocale()->locale;
    }

    public function setLocale(?string $locale = null): self
    {
        $this->locale = $locale ?? $this->app->getLocale();
        return $this;
    }

    /**
     * Custom Translation Loader
     * Registers the translator component with the application.
     * Sets the locale and fallback locale.
     */
    public function loadTranslations(): void
    {
        $this->app->bind(
            $this->translator,
            function ($app) {
                $trans = new Translator(
                    $this->loader(),
                    $this->locale ?? $this->locale($app)
                );
                if ($this->locale !== null) {
                    $trans->setFallback($app['config']['app.fallback_locale']);
                }
                $trans->addNamespace(
                    $this->config['nameSpace'],
                    $this->config['packageRootPath'] . $this->config['loadLangPath']
                );

                return $trans;
            }
        );
    }

    /**
     * Creates and returns a FileLoader instance.
     *
     * @return FileLoader
     */
    public function loader(): FileLoader
    {
        $filesystem = new Filesystem();
        $resourcesLangPath = $this->config['packageRootPath'] . $this->config['loaderLangPath'];

        if (!is_dir($resourcesLangPath)) {
            throw new \RuntimeException("Translation directory not found: $resourcesLangPath");
        }

        return new FileLoader($filesystem, $resourcesLangPath);
    }

    /**
     * Determines the locale from the request or defaults to the application locale.
     *
     * @param Application $app
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function locale(Application $app): string
    {
        return $app->get('request')
            ->segment(config('package-translator-loader.segment', 1))
            ?: $app->getLocale();
    }

    /**
     * Retrieves the translator instance from the service container.
     *
     * @return mixed
     */
    public function trans(): mixed
    {
        return app($this->translator);
    }
}
