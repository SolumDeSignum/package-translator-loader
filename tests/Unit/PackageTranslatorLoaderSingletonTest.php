<?php

declare(strict_types=1);

namespace SolumDeSignum\PackageTranslatorLoader\Tests\Unit;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;
use SolumDeSignum\PackageTranslatorLoader\PackageTranslatorLoaderServiceProvider;

class PackageTranslatorLoaderSingletonTest extends TestCase
{
    /**
     * @test
     */
    final public function transEnglish(): void
    {
        $__ = $this->app
            ->get('package-translator-loader')
            ->setLocale('en')
            ->trans()
            ->get(
                'package-translator-loader.run'
            );
        self::assertIsString($__);
        self::assertSame('I am running.', $__);
    }

    /**
     * @test
     */
    final public function transLatvian(): void
    {
        $__ = $this->app
            ->get('package-translator-loader')
            ->setLocale('lv')
            ->trans()
            ->get(
                'package-translator-loader.run'
            );
        self::assertIsString($__);
        self::assertSame('Es strādāju.', $__);
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
