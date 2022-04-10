<?php 

namespace Gamota\Dashboard\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Module extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Gamota\Dashboard\Services\Module::class;
    }
}
