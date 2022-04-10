<?php
/**
 * ModuleAlias: news
 * ModuleName: news
 * Description: This is the first file run of module. You can assign bootstrap or register module services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Gamota\Slider\Providers;

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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Slider');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'Slider');

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
            __DIR__.'/../../publishes/database/migrations' => database_path('migrations'),
        ], 'migration');

        $this->registerPolicies();
    }

    public function registerPolicies()
    {
        \AccessControl::define(trans('slider.slider') .' - '. trans('slider.list-slider'), 'admin.slider.index');
        \AccessControl::define(trans('slider.slider') .' - '. trans('slider.add-new-slider'), 'admin.slider.create');
        \AccessControl::define(trans('slider.slider') .' - '. trans('slider.edit-slider'), 'admin.slider.edit');
        \AccessControl::define(trans('slider.slider') .' - '. trans('slider.disable-slider'), 'admin.slider.disable');
        \AccessControl::define(trans('slider.slider') .' - '. trans('slider.enable-slider'), 'admin.slider.enable');
        \AccessControl::define(trans('slider.slider') .' - '. trans('slider.destroy-slider'), 'admin.slider.destroy');
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
    }

    private function registerAdminMenu()
    {
        add_action('admin.init', function () {
            // if (\Auth::user()->can('admin.slider.index')) {
            //     \AdminMenu::register('slider', [
            //         'parent'    =>  'main-manage',
            //         'label'     =>  trans('slider.slider'),
            //         'url'       =>  route('admin.slider.index'),
            //         'icon'      =>  'icon-notebook',
            //         'order' => '5',
            //     ]);
            // }

            // if (\Auth::user()->can('admin.slider.create')) {
            //     \AdminMenu::register('slider.create', [
            //         'parent'    =>  'slider',
            //         'label'     =>  trans('slider.add-new-slider'),
            //         'url'       =>  route('admin.slider.create'),
            //         'icon'      =>  'icon-note',
            //     ]);
            // }

            // if (\Auth::user()->can('admin.slider.index')) {
            //     \AdminMenu::register('slider.all', [
            //         'parent'    =>  'slider',
            //         'label'     =>  trans('slider.list-slider'),
            //         'url'       =>  route('admin.slider.index'),
            //         'icon'      =>  'icon-magnifier',
            //     ]);
            // }
        });
    }
}