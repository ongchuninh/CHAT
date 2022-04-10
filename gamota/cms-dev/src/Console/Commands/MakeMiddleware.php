<?php

namespace Gamota\CmsDev\Console\Commands;

use Gamota\CmsDev\Support\Abstracts\Generator;

class MakeMiddleware extends Generator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make:middleware {package} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new middleware class for package';

    protected $type = 'Middleware';

    protected function getStub()
    {
        return base_path('vendor/laravel/framework/src/Illuminate/Routing/Console/stubs/middleware.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Middleware';
    }
}
