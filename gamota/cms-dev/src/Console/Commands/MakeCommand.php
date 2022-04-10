<?php

namespace Gamota\CmsDev\Console\Commands;

use Gamota\CmsDev\Support\Abstracts\Generator;

class MakeCommand extends Generator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make:command {package} {name} {--command}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Artisan command for package';

    protected $type = 'Console command';

    protected function getStub()
    {
        return base_path('vendor\laravel\framework\src\Illuminate\Foundation\Console\stubs\console.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Command\Commands';
    }

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace('dummy:command', $this->option('command'), $stub);
    }
}
