<?php

namespace Gamota\CmsDev\Console\Commands;

use Illuminate\Support\Str;
use Gamota\CmsDev\Support\Abstracts\Generator;

class MakeListener extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'package:make:listener {package} {name} {--event=} {--queued}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new event listener class for package';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Listener';

    public function fire()
    {
        if (! $this->option('event')) {
            return $this->error('Missing required option: --event');
        }

        parent::fire();
    }

    protected function buildClass($name)
    {
        $event = $this->option('event');

        if (! Str::startsWith($event, $this->rootNamespace()) &&
            ! Str::startsWith($event, 'Illuminate')) {
            $event = $this->rootNamespace().'Events\\'.$event;
        }

        $stub = str_replace('DummyEvent', class_basename($event), parent::buildClass($name));

        return str_replace('DummyFullEvent', $event, $stub);
    }

    protected function getStub()
    {
        if ($this->option('queued')) {
            return base_path('vendor\laravel\framework\src\Illuminate\Foundation\Console\stubs\listener-queued.stub');
        } else {
            return base_path('vendor\laravel\framework\src\Illuminate\Foundation\Console\stubs\listener.stub');
        }
    }

    protected function alreadyExists($rawName)
    {
        return class_exists($rawName);
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Listeners';
    }
}
