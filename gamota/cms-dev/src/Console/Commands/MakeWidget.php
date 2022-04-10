<?php

namespace Gamota\CmsDev\Console\Commands;

use Gamota\CmsDev\Support\Abstracts\Generator;

class MakeWidget extends Generator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:make:widget {package} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new widget class for package';

    protected $type = 'Widget';

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Widgets';
    }

    protected function getStub()
    {
        return __DIR__.'/../../../resources/stub/widget.stub';
    }
}
