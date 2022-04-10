<?php

namespace Gamota\Dashboard\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Action extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Gamota\Dashboard\Services\Action::class;
    }
}
