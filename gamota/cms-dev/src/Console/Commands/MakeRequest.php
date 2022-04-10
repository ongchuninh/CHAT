<?php

namespace Gamota\CmsDev\Console\Commands;

use Gamota\CmsDev\Support\Abstracts\Generator;

class MakeRequest extends Generator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make:request {package} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new request class for package';

    protected $type = 'Request';

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Requests';
    }

    protected function getStub()
    {
        return base_path('vendor\laravel\framework\src\Illuminate\Foundation\Console\stubs\request.stub');
    }
}
