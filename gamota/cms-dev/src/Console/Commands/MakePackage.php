<?php

namespace Gamota\CmsDev\Console\Commands;

use Illuminate\Console\Command;

class MakePackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create package for Phambinhcms.';

    protected $name;
    protected $packageDirname;
    protected $packageNamespace;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->name = $this->argument('name');
        $this->packageDirname = str_slug($this->name);
        $this->packageNamespace = package_namespace($this->name);

        if (!$this->packageExists()) {
            \File::copyDirectory($this->getSourcePackage(), $this->getDestinationPackage());
            $allFiles = \File::allFiles($this->getDestinationPackage());
            foreach ($allFiles as $file) {
                $content = $this->replacePlaceholders($file->getContents());
                \File::put($file->getRealPath(), $content);
            }
            $this->info('Package create successfully.');
        } else {
            $this->error('Package is exists.');
        }
    }

    private function getSourcePackage()
    {
        return __DIR__.'/../../../resources/stub/package-struct';
    }

    private function getDestinationPackage()
    {
        return package_path($this->packageDirname);
    }

    private function packageExists()
    {
        return is_dir($this->getDestinationPackage());
    }

    private function replacePlaceholders($content)
    {
        $find = [
            'DummyNamespace',
            'DummyUcfirst',
            'DummyName',
        ];

        $replace = [
            $this->packageNamespace,
            class_basename($this->packageNamespace),
            $this->name,
        ];

        return str_replace($find, $replace, $content);
    }
}
