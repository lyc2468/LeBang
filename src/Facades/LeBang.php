<?php

namespace Skies\LeBang\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Skies\LeBang\LeBang
 */
class LeBang extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'lebang';
    }
}
