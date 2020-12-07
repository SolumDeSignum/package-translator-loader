<?php

declare(strict_types=1);

namespace SolumDeSignum\PackageTranslatorLoader\Facades;

use Illuminate\Support\Facades\Facade;

class PackageTranslatorLoader extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'package-translator-loader';
    }
}
