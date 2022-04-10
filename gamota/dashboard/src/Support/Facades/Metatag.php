<?php

namespace Gamota\Dashboard\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Metatag extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Gamota\Dashboard\Services\Metatag::class;
    }
}
