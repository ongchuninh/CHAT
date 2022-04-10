<?php

namespace Gamota\CmsDev\Console\Commands;

use Gamota\CmsDev\Support\Abstracts\Generator;

class MakeEvent extends Generator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make:event {package} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new event class for package';

    protected $type = 'Event';

    protected function getStub()
    {
        return base_path('vendor\laravel\framework\src\Illuminate\Foundation\Console\stubs\event.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Events';
    }
}
