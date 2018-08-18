<?php

namespace Alive2212\LaravelCryptService\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelCryptService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'LaravelCryptService';
    }
}
