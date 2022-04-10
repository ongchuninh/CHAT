<?php

namespace Gamota\Dashboard\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Filter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Gamota\Dashboard\Services\Filter::class;
    }
}
