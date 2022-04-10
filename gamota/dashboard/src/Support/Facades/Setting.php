<?php

namespace Gamota\Dashboard\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Setting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Gamota\Dashboard\Services\Setting::class;
    }
}
