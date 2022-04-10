<?php

namespace Gamota\CmsDev\Console\Commands;

use Gamota\CmsDev\Support\Abstracts\Generator;

class MakePolicy extends Generator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make:policy {package} {name} {--model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new policy class for package';

    protected $type = 'Policy';

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $model = $this->option('model');

        return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    protected function replaceModel($stub, $model)
    {
        $model = str_replace('/', '\\', $model);

        if (Str::startsWith($model, '\\')) {
            $stub = str_replace('NamespacedDummyModel', trim($model, '\\'), $stub);
        } else {
            $stub = str_replace('NamespacedDummyModel', $this->rootNamespace().$model, $stub);
        }

        $model = class_basename(trim($model, '\\'));

        $stub = str_replace('DummyModel', $model, $stub);

        $stub = str_replace('dummyModel', Str::camel($model), $stub);

        return str_replace('dummyPluralModel', Str::plural(Str::camel($model)), $stub);
    }

    protected function getStub()
    {
        return $this->option('model')
            ? base_path('vendor\laravel\framework\src\Illuminate\Foundation\Console\stubs\policy.stub')
            : base_path('vendor\laravel\framework\src\Illuminate\Foundation\Console\stubs\policy.plain.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Policies';
    }
}
