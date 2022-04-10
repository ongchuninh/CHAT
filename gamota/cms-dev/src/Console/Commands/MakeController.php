<?php

namespace Gamota\CmsDev\Console\Commands;

use Gamota\CmsDev\Support\Abstracts\Generator;

class MakeController extends Generator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make:controller {package} {name} {--resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new controller class for package';

    protected $type = 'Controller';

    protected function getStub()
    {
        if ($this->option('resource')) {
            return base_path('vendor/laravel/framework/src/Illuminate/Routing/Console/stubs/controller.stub');
        }

        return base_path('vendor/laravel/framework/src/Illuminate/Routing/Console/stubs/controller.plain.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }
}
