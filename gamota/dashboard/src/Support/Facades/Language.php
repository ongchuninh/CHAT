<?php

namespace Gamota\Dashboard\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Language extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Gamota\Dashboard\Services\Language::class;
    }
}
