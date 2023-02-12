<?php

declare(strict_types=1);

namespace SolumDeSignum\PackageTranslatorLoader;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;

use function app;
use function config;

class PackageTranslatorLoader
{
    public array $config;

    public ?string $locale = null;

    private string $translator;

    private Application $app;

    public function __construct(
        Application $app,
        array $config = [
            'translator' => 'package-translation-loader.translator',
            'nameSpace' => 'solumdesignum/package-translation-loader',
            'packageRootPath' => __DIR__ . '/..',
            'loadLangPath' => '/../resources/lang',
            'loaderLangPath' => '/resources/lang',
        ],
        ?string $locale = null
    ) {
        $this->app = $app;
        $this->config = $config;
        $this->translator = $this->config['translator'];
        $this->localeSetter($locale);
        $this->loadTranslations();
    }

    private function localeSetter(?string $locale): void
    {
        if ($locale !== null) {
            $this->locale = $locale;
        } else {
            $this->setLocale();
        }
    }

    final public function setLocale(?string $locale = null): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Custom Translation Loader
     *  When registering the translator component, we'll need to set the default
     * locale as well as the fallback locale. So, we'll grab the application
     * configuration so we can easily get both of these values from there.
     *
     * @return void
     */
    final public function loadTranslations(): void
    {
        $this->app->bind(
            $this->translator,
            function ($app) {
                $trans = new Translator(
                    $this->loader(),
                    (string)($this->locale !== null
                        ? $this->locale
                        : $this->locale($app))
                );
                $this->locale !== null
                    ? $this->locale
                    : $trans->setFallback(
                    $app['config']['app.fallback_locale']
                );
                $trans->addNamespace(
                    $this->config['nameSpace'],
                    __DIR__ .
                    $this->config['loadLangPath']
                );

                return $trans;
            }
        );
    }

    private function loader(): FileLoader
    {
        $filesystem = new Filesystem();
        $resourcesLangPath = $this->config['packageRootPath'] . $this->config['loaderLangPath'];
        $filesystem->allFiles($resourcesLangPath);

        return new FileLoader($filesystem, $resourcesLangPath);
    }

    private function locale(Application $app): string
    {
        return $app
            ->get('request')
            ->segment(
                config('package-translator-loader.segment', 1)
            ) ?: $app->getLocale();
    }

    final public function trans(): mixed
    {
        return app($this->translator);
    }
}
