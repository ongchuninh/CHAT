<?php

namespace Gamota\CmsDev\Console\Commands;

use Gamota\CmsDev\Support\Abstracts\Generator;

class MakeJob extends Generator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make:job {package} {name} {--sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new job class for package';

    protected $type = 'Job';

    protected function getStub()
    {
        return $this->option('sync')
                ? base_path('vendor\laravel\framework\src\Illuminate\Foundation\Console\stubs\job.stub')
                : base_path('vendor\laravel\framework\src\Illuminate\Foundation\Console\stubs\job-queued.stub');

        return ;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Job';
    }
}
