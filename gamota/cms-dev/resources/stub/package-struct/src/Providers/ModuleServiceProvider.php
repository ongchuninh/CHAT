<?php

namespace DummyNamespace\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application Services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->publishes([
        //     __DIR__.'/../../publishes/database/migrations' => database_path('migrations'),
        // ], 'migration');

        $this->publishes([
            __DIR__.'/../../publishes/config' => config_path(),
        ], 'config');
            
        $this->publishes([
            __DIR__.'/../../publishes/resources' => resource_path(),
        ], 'resource');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'DummyUcfirst');

        // Load helper
        if (\File::exists(__DIR__ . '/../../helper/helper.php')) {
            include __DIR__ . '/../../helper/helper.php';
        }

        $this->registerPolices();
    }

    /**
     * Register the application Services.
     *
     * @return void
     */
    public function register()
    {
        \Module::registerFromComposerJson(__DIR__.'/../..');
        $this->registerAdminMenu();
    }

    private function registerPolices()
    {
        //
    }

    private function registerAdminMenu()
    {
        // add_action('admin.init', function () {
        //     //
        // });
    }
}
