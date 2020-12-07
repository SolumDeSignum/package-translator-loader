<?php

declare(strict_types=1);

namespace SolumDeSignum\PackageTranslatorLoader\Contracts;

/**
 * Interface PackageTranslatorLoaderContract
 * @package SolumDeSignum\LanguagesI18n\Contracts
 */
interface PackageTranslatorLoaderContract
{
    /**
     * @return string
     */
    public function packageRootPath(): string;
}
