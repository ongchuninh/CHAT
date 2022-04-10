<?php

namespace Gamota\Appearance\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Menu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Gamota\Appearance\Services\Menu::class;
    }
}
