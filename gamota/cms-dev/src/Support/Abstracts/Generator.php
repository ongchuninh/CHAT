<?php

namespace Gamota\CmsDev\Support\Abstracts;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

abstract class Generator extends GeneratorCommand
{
    protected $type;

    public function fire()
    {
        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        if (!$this->packageExists($this->getPackageInput())) {
            $this->error('Package not already exists!');

            return false;
        }

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $a = $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($name));

        $this->info($this->type.' created successfully.');
    }

    protected function getPackageInput()
    {
        return $this->argument('package');
    }

    protected function rootNamespace()
    {
        return package_namespace($this->getPackageInput()) . '\\';
    }

    protected function alreadyExists($rawName)
    {
        return $this->files->exists($this->getPath($this->qualifyClass($rawName)));
    }

    protected function packageExists($package)
    {
        return is_dir(package_path($package));
    }

    protected function getPath($name)
    {
        $name = str_replace_first($this->rootNamespace(), '', $name);
        return package_path($this->getPackageInput() . '/src//') . str_replace('\\', '/', $name).'.php';
    }
}
