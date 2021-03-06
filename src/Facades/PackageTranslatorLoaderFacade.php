<?php

declare(strict_types=1);

namespace SolumDeSignum\PackageTranslatorLoader\Facades;

use Illuminate\Support\Facades\Facade;
use SolumDeSignum\PackageTranslatorLoader\PackageTranslatorLoader;

class PackageTranslatorLoaderFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return PackageTranslatorLoader::class;
    }
}
