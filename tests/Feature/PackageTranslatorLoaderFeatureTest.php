<?php

declare(strict_types=1);

namespace SolumDeSignum\PackageTranslatorLoader\Tests\Feature;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase;
use SolumDeSignum\PackageTranslatorLoader\PackageTranslatorLoaderServiceProvider;

class PackageTranslatorLoaderFeatureTest extends TestCase
{
    /**
     * @test
     */
    public function itTranslatesTextInEnglish(): void
    {
        $translator = $this->app->get('package-translator-loader');
        $translator->setLocale('en');
        $translation = $translator->trans()->get('package-translator-loader.run');

        $this->assertEquals('I am running.', $translation);
    }

    /**
     * @test
     */
    public function itTranslatesTextInLatvian(): void
    {
        $translator = $this->app->get('package-translator-loader');
        $translator->setLocale('lv');
        $translation = $translator->trans()->get('package-translator-loader.run');

        $this->assertEquals('Es strādāju.', $translation);
    }

    /**
     * @test
     */
    public function itSetsAndRetrievesLocaleCorrectly(): void
    {
        $translator = $this->app->get('package-translator-loader');
        $translator->setLocale('fr');

        $this->assertEquals('fr', $translator->locale);
    }

    /**
     * @test
     */
    public function itFallsBackToDefaultLocale(): void
    {
        Config::set('app.fallback_locale', 'en');

        $translator = $this->app->get('package-translator-loader');
        $translator->setLocale('invalid-locale');
        $translation = $translator->trans()->get('package-translator-loader.run');

        $this->assertEquals('I am running.', $translation);
    }

    /**
     * @test
     */
    public function itUsesDefaultLocaleWhenNoLocaleIsSet(): void
    {
        $translator = $this->app->get('package-translator-loader');
        $translator->setLocale(null); // Or leave it unset

        $translation = $translator->trans()->get('package-translator-loader.run');
        $this->assertEquals('I am running.', $translation); // Assuming default locale is 'en'
    }

    /**
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            PackageTranslatorLoaderServiceProvider::class,
        ];
    }
}
