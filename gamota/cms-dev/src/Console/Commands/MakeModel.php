<?php

namespace Gamota\CmsDev\Console\Commands;

use Gamota\CmsDev\Support\Abstracts\Generator;

class MakeModel extends Generator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make:model {package} {name} {--migration} {--controller} {--resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model class for package';

    protected $type = 'Model';

    protected function getStub()
    {
        return base_path('vendor\laravel\framework\src\Illuminate\Foundation\Console\stubs\model.stub');
    }

    public function fire()
    {
        if (parent::fire() === false) {
            return;
        }

        if ($this->option('migration')) {
            $this->createMigration();
        }

        if ($this->option('controller') || $this->option('resource')) {
            $this->createController();
        }
    }

    protected function createMigration()
    {
        $table = Str::plural(Str::snake(class_basename($this->argument('name'))));

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('package:make:controller', [
            'package' => $this->getPackageInput(),
            'name' => "{$controller}Controller",
            '--model' => $this->option('resource') ? $modelName : null,
        ]);
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }
}
