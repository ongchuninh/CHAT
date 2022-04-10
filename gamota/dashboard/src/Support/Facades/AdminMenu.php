<?php 

namespace Gamota\Dashboard\Support\Facades;

use Illuminate\Support\Facades\Facade;

class AdminMenu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Gamota\Dashboard\Services\AdminMenu::class;
    }
}
