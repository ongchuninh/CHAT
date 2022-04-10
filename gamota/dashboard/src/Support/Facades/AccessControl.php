<?php

namespace Gamota\Dashboard\Support\Facades;

use Illuminate\Support\Facades\Facade;

class AccessControl extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Gamota\Dashboard\Services\AccessControl::class;
    }
}
