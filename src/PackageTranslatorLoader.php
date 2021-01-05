<?php

declare(strict_types=1);

namespace SolumDeSignum\PackageTranslatorLoader;

use function app;
use function config;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;

use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;

class PackageTranslatorLoader
{
    /**
     * @var array
     */
    public array $config;

    /**
     * @var string|null
     */
    public ?string $locale = null;

    /**
     * @var string
     */
    private string $translator;

    /**
     * @var Application
     */
    private Application $app;

    /**
     * PackageTranslatorLoader constructor.
     *
     * @param Application    $app
     * @param array|string[] $config
     * @param string|null    $locale
     */
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
                    (string)($this->locale !== null ?
                        $this->locale :
                        $this->locale(
                            $app
                        ))
                );
                $this->locale !== null ? $this->locale : $trans->setFallback(
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

    /**
     * @param string|null $locale
     *
     * @return $this
     */
    final public function setLocale(?string $locale = null): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return Application|mixed|string
     */
    final public function trans()
    {
        return app($this->translator);
    }

    /**
     * @param string|null $locale
     */
    private function localeSetter(?string $locale): void
    {
        if ($locale !== null) {
            $this->locale = $locale;
        } else {
            $this->setLocale();
        }
    }

    /**
     * @param Application $app
     *
     * @return string
     */
    private function locale(Application $app): string
    {
        return $app
            ->get('request')
            ->segment(
                config('package-translator-loader.segment', 1)
            ) ?: $app->getLocale();
    }

    /**
     * @return FileLoader
     */
    private function loader(): FileLoader
    {
        $filesystem = new Filesystem();
        $resourcesLangPath = $this->config['packageRootPath'] . $this->config['loaderLangPath'];
        $filesystem->allFiles($resourcesLangPath);
        return new FileLoader($filesystem, $resourcesLangPath);
    }
}
