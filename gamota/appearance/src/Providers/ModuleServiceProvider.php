<?php

namespace Gamota\Appearance\Providers;

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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Appearance');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'Appearance');

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

        $this->registerPolicies();
    }

    public function registerPolicies()
    {
        \AccessControl::define(trans('menu.appearance').' - '.trans('menu.list-menu'), 'admin.appearance.menu.index');
        \AccessControl::define(trans('menu.appearance').' - '.trans('menu.add-new-menu'), 'admin.appearance.menu.create');
        \AccessControl::define(trans('menu.appearance').' - '.trans('menu.edit-menu'), 'admin.appearance.menu.edit');
        \AccessControl::define(trans('menu.appearance').' - '.trans('menu.destroy-menu'), 'admin.appearance.menu.destroy');

        \AccessControl::define(trans('frontend.appearance').' - '.trans('frontend.list-frontend'), 'admin.appearance.frontend.index');
        \AccessControl::define(trans('frontend.appearance').' - '.trans('frontend.add-new-frontend'), 'admin.appearance.frontend.create');
        \AccessControl::define(trans('frontend.appearance').' - '.trans('frontend.edit-frontend'), 'admin.appearance.frontend.edit');
        \AccessControl::define(trans('frontend.appearance').' - '.trans('frontend.destroy-frontend'), 'admin.appearance.frontend.destroy');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \Module::registerFromComposerJson(__DIR__.'/../..');
        $this->registerAdminMenu();
        \Menu::registerLocation([
            'id' => 'master-menu',
            'name' => 'Master menu',
        ]);
    }

    private function registerAdminMenu()
    {
        add_action('admin.init', function () {
            if (\Auth::user()->can('admin.appearance.menu.index')) {
                \AdminMenu::register('setting.appearance', [
                    'label'     => trans('menu.setting-appearance'),
                    'parent'    =>  'setting',
                    'url'       =>  route('admin.appearance.menu.index'),
                    'icon'      =>  'icon-grid',
                ]);
            }
            if (\Auth::user()->can('admin.appearance.menu.index')) {
                \AdminMenu::register('setting.appearance.menu', [
                    'label'     => trans('menu.menu'),
                    'parent'    =>  'setting.appearance',
                    'url'       =>  route('admin.appearance.menu.index'),
                    'icon'      =>  'icon-list',
                ]);
            }

            if (\Auth::user()->can('admin.appearance.frontend.index')) {
                \AdminMenu::register('setting.appearance.frontend', [
                    'label'     => trans('frontend.frontend'),
                    'parent'    =>  'setting.appearance',
                    'url'       =>  route('admin.appearance.frontend.index'),
                    'icon'      =>  'icon-layers',
                ]);
            }

            if (\Auth::user()->can('admin')) {
                \AdminMenu::register('setting.check-version', [
                    'label'     => trans('styleguide.style-guide'),
                    'parent'    =>  'setting',
                    'url'       =>  route('admin.appearance.style-guide.index'),
                    'icon'      =>  'icon-drop',
                ]);
            }
        });
    }
}
