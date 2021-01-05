<?php

declare(strict_types=1);

use Illuminate\Contracts\Foundation\Application;

if (! function_exists('translator')) {
    /**
     * @param string|null $translator
     * @param string|null $key
     *
     * @return Application|mixed|string|null
     * @throws Exception
     */
    function translator(string $translator = null, string $key = null)
    {
        if ($translator !== null && $key === null) {
            throw new Exception(
                'Please set translation key'
            );
        }

        if ($translator === null && $key === null) {
            throw new Exception(
                'Please provide translator and translation key'
            );
        }

        return app($translator)->get($key);
    }
}
