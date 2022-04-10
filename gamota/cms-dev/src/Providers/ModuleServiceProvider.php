<?php

namespace Gamota\CmsDev\Providers;

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
        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'CmsDev');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'CmsDev');
        
        // Load helper
        if (\File::exists(__DIR__ . '/../../helper/helper.php')) {
            include __DIR__ . '/../../helper/helper.php';
        }
    }

    /**
     * Register the application Services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
