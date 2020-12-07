<?php

declare(strict_types=1);

namespace SolumDeSignum\PackageTranslatorLoader\Traits;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;

/**
 * Trait PackageTranslatorLoader
 * @package SolumDeSignum\PackageTranslatorLoader\Traits
 */
trait PackageTranslatorLoader
{
    /**
     * @var string
     */
    public string $translator;

    /**
     * @param string $key
     *
     * @return string
     */
    final public function trans(string $key): string
    {
        return app($this->translator)->get($key);
    }

    /**
     * Custom Translation Loader
     *  When registering the translator component, we'll need to set the default
     * locale as well as the fallback locale. So, we'll grab the application
     * configuration so we can easily get both of these values from there.
     *
     * @param Application $app
     *
     * @param string      $nameSpace
     *
     * @return void
     */
    final public function loadTranslations(Application $app, string $nameSpace): void {
        $app->bind($this->translator, function ($app) use ($nameSpace) {
            $trans = new Translator($this->loader(), $app->get('request')->segment(1) ?? $app->getLocale());
            $trans->setFallback($app['config']['app.fallback_locale']);
            $trans->addNamespace($nameSpace, __DIR__ . '/../resources/lang');
            return $trans;
        });
    }

    /**
     * @return FileLoader
     */
    private function loader(): FileLoader
    {
        $filesystem = new Filesystem();
        $resourcesLangPath = $this->packageRootPath() . '/resources/lang';
        $filesystem->allFiles($resourcesLangPath);
        return new FileLoader($filesystem, $resourcesLangPath);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    final public function packageRootPath(string $path = '/..' ): string
    {
        return __DIR__ . $path;
    }
}
