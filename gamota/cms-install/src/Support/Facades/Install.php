<?php

namespace Gamota\CmsInstall\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Install extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Gamota\CmsInstall\Services\Install::class;
    }
}
