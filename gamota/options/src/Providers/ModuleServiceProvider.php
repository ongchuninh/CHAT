<?php

/**
 * ModuleAlias: news
 * ModuleName: news
 * Description: This is the first file run of module. You can assign bootstrap or register module services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */

namespace Gamota\Options\Providers;

use Illuminate\Support\Facades\Gate;
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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Options');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'Options');

        // Load helper
        if (\File::exists(__DIR__ . '/../../helper/helper.php')) {
            include __DIR__ . '/../../helper/helper.php';
        }

        /*
        $this->publishes([
            __DIR__.'/../../publishes/resources' => resource_path(),
        ], 'resource');
        */

        $this->publishes([
            __DIR__ . '/../../publishes/database/migrations' => database_path('migrations'),
        ], 'migration');

        $this->registerPolicies();
    }

    //đăng ký phân quyền
    public function registerPolicies()
    {
        \AccessControl::define(trans('option.option') . ' - ' . trans('option.list-option'), 'admin.option.index');
        \AccessControl::define(trans('option.option') . ' - ' . trans('option.add-new-option'), 'admin.option.create');
        \AccessControl::define(trans('option.option') . ' - ' . trans('option.edit-option'), 'admin.option.edit');
        \AccessControl::define(trans('option.option') . ' - ' . trans('option.disable-option'), 'admin.option.disable');
        \AccessControl::define(trans('option.option') . ' - ' . trans('option.enable-option'), 'admin.option.enable');
        \AccessControl::define(trans('option.option') . ' - ' . trans('option.destroy-option'), 'admin.option.destroy');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \Module::registerFromComposerJson(__DIR__ . '/../..');
        $this->registerAdminMenu();
    }

    private function registerAdminMenu()
    {
        add_action('admin.init', function () {
            if (\Auth::user()->can('admin.option.index')) {
                \AdminMenu::register('option', [
                    'parent'    =>  '0',
                    'label'     =>  'Cài đặt trang',
                    
                    'icon'      =>  'icon-notebook',
                ]);
            }
            if (\Auth::user()->can('admin.option.index')) {
                \AdminMenu::register('option.home', [
                    'parent'    =>  'option',
                    'label'     =>  trans('Options::option.home'),
                    'url'       =>  route('admin.option.home'),
                    'icon'      =>  'icon-notebook',
                ]);
            }

            if (\Auth::user()->can('admin.option.index')) {
                \AdminMenu::register('option.gamota', [
                    'parent'    =>  'option',
                    'label'     =>  'Trang Gamota',
                    'url'       =>  route('admin.option.gamota'),
                    'icon'      =>  'icon-notebook',
                ]);
            }

            if (\Auth::user()->can('admin.option.index')) {
                \AdminMenu::register('option.games', [
                    'parent'    =>  'option',
                    'label'     =>  'Trang Games',
                    'url'       =>  route('admin.option.games'),
                    'icon'      =>  'icon-notebook',
                ]);
            }

            if (\Auth::user()->can('admin.option.index')) {
                \AdminMenu::register('option.service', [
                    'parent'    =>  'option',
                    'label'     =>  'Trang dịch vụ',
                    'url'       =>  route('admin.option.service'),
                    'icon'      =>  'icon-notebook',
                ]);
            }
            //admin.option.garenal

            if (\Auth::user()->can('admin.option.index')) {
                \AdminMenu::register('option.contact', [
                    'parent'    =>  'option',
                    'label'     =>  'Trang Liên hệ',
                    'url'       =>  route('admin.option.contact'),
                    'icon'      =>  'icon-notebook',
                ]);
            }
            if (\Auth::user()->can('admin.option.index')) {
                \AdminMenu::register('option.general', [
                    'parent'    =>  'option',
                    'label'     =>  'Cài đặt chung',
                    'url'       =>  route('admin.option.general'),
                    'icon'      =>  'icon-notebook',
                ]);
            }

            if (\Auth::user()->can('admin.option.index')) {
                \AdminMenu::register('option.language', [
                    'parent'    =>  'option',
                    'label'     =>  'Cài đặt ngôn ngữ',
                    'url'       =>  route('admin.option.language'),
                    'icon'      =>  'icon-notebook',
                ]);
            }
        });
    }
}