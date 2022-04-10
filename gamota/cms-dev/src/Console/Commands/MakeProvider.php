<?php

namespace Gamota\CmsDev\Console\Commands;

use Gamota\CmsDev\Support\Abstracts\Generator;

class MakeProvider extends Generator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make:provider {package} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new provider class for package';

    protected $type = 'Provider';

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Providers';
    }

    protected function getStub()
    {
        return base_path('vendor\laravel\framework\src\Illuminate\Foundation\Console\stubs\provider.stub');
    }
}
