<?php

declare(strict_types=1);

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

if (!function_exists('translator')) {
    /**
     * @param string|null $translator
     * @param string|null $key
     *
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function translator(string $translator = null, string $key = null): mixed
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
