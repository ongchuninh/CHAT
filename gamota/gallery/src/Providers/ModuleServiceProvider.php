<?php
/**
 * ModuleAlias: news
 * ModuleName: news
 * Description: This is the first file run of module. You can assign bootstrap or register module services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Gamota\Gallery\Providers;

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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Gallery');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'Gallery');

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
        \AccessControl::define(trans('gallery.gallery') .' - '. trans('gallery.list-gallery'), 'admin.gallery.index');
        \AccessControl::define(trans('gallery.gallery') .' - '. trans('gallery.add-new-gallery'), 'admin.gallery.create');
        \AccessControl::define(trans('gallery.gallery') .' - '. trans('gallery.edit-gallery'), 'admin.gallery.edit');
        \AccessControl::define(trans('gallery.gallery') .' - '. trans('gallery.disable-gallery'), 'admin.gallery.disable');
        \AccessControl::define(trans('gallery.gallery') .' - '. trans('gallery.enable-gallery'), 'admin.gallery.enable');
        \AccessControl::define(trans('gallery.gallery') .' - '. trans('gallery.destroy-gallery'), 'admin.gallery.destroy');

        \AccessControl::define(trans('gallery.gallery') .' - '. trans('gallery.category.list-category'), 'admin.gallery.category.index');
        \AccessControl::define(trans('gallery.gallery') .' - '. trans('gallery.category.add-new-category'), 'admin.gallery.category.create');
        \AccessControl::define(trans('gallery.gallery') .' - '. trans('gallery.category.edit-category'), 'admin.gallery.category.edit');
        \AccessControl::define(trans('gallery.gallery') .' - '. trans('gallery.category.destroy'), 'admin.gallery.category.destroy');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \Module::registerFromComposerJson(__DIR__.'/../..');
        \Menu::registerType('Danh mục tin', \Gamota\News\Category::class);
        $this->registerAdminMenu();
    }

    private function registerAdminMenu()
    {
        add_action('admin.init', function () {
            // if (\Auth::user()->can('admin.gallery.index')) {
            //     \AdminMenu::register('gallery', [
            //         'parent'    =>  'main-manage',
            //         'label'     =>  trans('gallery.gallery'),
            //         'url'       =>  route('admin.gallery.index'),
            //         'icon'      =>  'icon-picture',
            //         'order' => '5',
            //     ]);
            // }

            // if (\Auth::user()->can('admin.gallery.create')) {
            //     \AdminMenu::register('gallery.create', [
            //         'parent'    =>  'gallery',
            //         'label'     =>  trans('gallery.add-new-gallery'),
            //         'url'       =>  route('admin.gallery.create'),
            //         'icon'      =>  'icon-note',
            //     ]);
            // }

            // if (\Auth::user()->can('admin.gallery.index')) {
            //     \AdminMenu::register('gallery.all', [
            //         'parent'    =>  'gallery',
            //         'label'     =>  trans('gallery.list-gallery'),
            //         'url'       =>  route('admin.gallery.index'),
            //         'icon'      =>  'icon-magnifier',
            //     ]);
            // }

            // if (\Auth::user()->can('admin.gallery.category.index')) {
            //     \AdminMenu::register('gallery.category', [
            //         'parent'    =>  'gallery',
            //         'label'     =>  trans('gallery.category.category'),
            //         'url'       =>  route('admin.gallery.category.index'),
            //         'icon'      =>  'icon-list',
            //     ]);
            // }
        });
    }
}