<?php

namespace Gamota\Promise\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Promise');

        // Load helper
        if (\File::exists(__DIR__ . '/../../helper/helper.php')) {
            include __DIR__ . '/../../helper/helper.php';
        }

        $this->publishes([
            __DIR__.'/../../publishes/resources' => resource_path(),
        ], 'resource');
        
        $this->publishes([
            __DIR__.'/../../publishes/database/migrations' => database_path('migrations'),
        ], 'migration');

        $this->registerPolices();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \Module::registerFromComposerJson(__DIR__.'/../..');
        \Menu::registerType('Trang tĩnh', \Gamota\Promise\Promise::class);
        $this->registerAdminMenu();
    }

    private function registerPolices()
    {
        \AccessControl::define(trans('promise.promise') .' - '.trans('promise.add-new-promise'), 'admin.promise.create');
        \AccessControl::define(trans('promise.promise') .' - '.trans('promise.list-promise'), 'admin.promise.index');
        \AccessControl::define(trans('promise.promise') .' - '.trans('promise.disable-promise'), 'admin.promise.disable');
        \AccessControl::define(trans('promise.promise') .' - '.trans('promise.enable-promise'), 'admin.promise.enable');
        \AccessControl::define(trans('promise.promise') .' - '.trans('promise.edit-promise'), 'admin.promise.edit');
        \AccessControl::define(trans('promise.promise') .' - '.trans('promise.destroy-promise'), 'admin.promise.destroy');
    }

    private function registerAdminMenu()
    {
        add_action('admin.init', function () {
            // if (\Auth::user()->can('admin.promise.index')) {
            //     \AdminMenu::register('promise', [
            //         'parent' => 'main-manage',
            //         'label' => trans('promise.promise'),
            //         'icon' => 'icon-user-follow',
            //         'url'   => route('admin.promise.index'),
            //         'order' => '2',
            //     ]);
            // }
            // if (\Auth::user()->can('admin.promise.index')) {
            //     \AdminMenu::register('promise.index', [
            //         'parent' => 'promise',
            //         'label' => trans('promise.list-promise'),
            //         'icon' => 'icon-list',
            //         'url'   => route('admin.promise.index'),
            //     ]);
            // }
        });
    }
}