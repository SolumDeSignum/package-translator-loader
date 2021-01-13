[![StyleCI](https://github.styleci.io/repos/changeME/shield?branch=master)](https://github.styleci.io/repos/145921620)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/solumdesignum/package-translator-loader/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/solumdesignum/package-translator-loader/?branch=master)
[![Total Downloads](https://poser.pugx.org/solumdesignum/package-translator-loader/downloads)](https://packagist.org/packages/solumdesignum/package-translator-loader)
[![Latest Stable Version](https://poser.pugx.org/solumdesignum/package-translator-loader/v/stable)](https://packagist.org/packages/solumdesignum/package-translator-loader)
[![Latest Unstable Version](https://poser.pugx.org/solumdesignum/package-translator-loader/v/unstable)](https://packagist.org/packages/solumdesignum/package-translator-loader)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

## Introduction
Laravel Package Translator Loader is translations loader that will help to   
translation your package fully (Finally about time, I would say!!!).


## Installation
To get started, install Package Translator Loader using the Composer package manager:
```shell
composer require solumdesignum/package-translator-loader
```

### Features
The configuration file contains configurations.
```php
<?php

declare(strict_types=1);

return [
    'segment' => 1
];
````

# Usage
```php
<?php

declare(strict_types=1);

namespace SolumDeSignum\ThemeManager;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use SolumDeSignum\PackageTranslatorLoader\PackageTranslatorLoader;

class ExampleServiceProvider extends ServiceProvider
{
    /**
     * @var PackageTranslatorLoader
     */
    private PackageTranslatorLoader $packageTranslatorLoader;

    /**
     * ExampleServiceProvider constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->packageTranslatorLoader = new PackageTranslatorLoader(
            $this->app,
            [
                'translator' => 'theme-manager.translator',
                'nameSpace' => 'solumdesignum/theme-manager',
                'packageRootPath' => __DIR__ . '/..',
                'loadLangPath' => '/../resources/lang',
                'loaderLangPath' => '/resources/lang',
            ]
        );
    }
}
````

# Usage: Accessing Translations
```php
<?php

declare(strict_types=1);

/**
 * Internal package translations
 * Even exceptions for both examples
 */
 
/**
 * Internal Translator instance
 * inside function get() should pass package name with translation key (package.translation-key)
 */
    $this->packageTranslatorLoader->trans()
        ->get('theme-manager.invalid_argument_exception');
        
/**
 * Helper: can be used in Blade, Controllers, Models, Services and etc...
 * Inside first key must pass name of translator 
 * Inside second key must pass package name with translation key (package.translation-key)
 */
translator(
    'theme-manager.translator',
    'theme-manager.invalid_argument_exception'
);
````

## Contributing
Thank you for considering contributing to the Laravel Package Translator Loader. 
You can read the contribution guidelines [here](contributing.md)

## Security
If you discover any security-related issues, please email to [Solum DeSignum](mailto:oskars_germovs@inbox.lv).

## Author
- [Oskars Germovs](https://github.com/Faks)

## About
[Solum DeSignum](https://solum-designum.eu) is a web design agency based in Latvia, Riga.

## License
Laravel Package Translator Loader is open-sourced software licensed under the [MIT license](license.md)
