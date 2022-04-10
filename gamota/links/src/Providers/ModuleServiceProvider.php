<?php
/**
 * ModuleAlias: links
 * ModuleName: links
 * Description: This is the first file run of module. You can assign bootstrap or register module services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Gamota\Links\Providers;

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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Links');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'Links');

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
        \AccessControl::define(trans('links.links') .' - '. trans('links.list-links'), 'admin.links.index');
        \AccessControl::define(trans('links.links') .' - '. trans('links.add-new-links'), 'admin.links.create');
        \AccessControl::define(trans('links.links') .' - '. trans('links.edit-links'), 'admin.links.edit');
        \AccessControl::define(trans('links.links') .' - '. trans('links.disable-links'), 'admin.links.disable');
        \AccessControl::define(trans('links.links') .' - '. trans('links.enable-links'), 'admin.links.enable');
        \AccessControl::define(trans('links.links') .' - '. trans('links.destroy-links'), 'admin.links.destroy');
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
            // if (\Auth::user()->can('admin.links.index')) {
            //     \AdminMenu::register('links', [
            //         'parent'    =>  'main-manage',
            //         'label'     =>  trans('links.links'),
            //         'url'       =>  route('admin.links.index'),
            //         'icon'      =>  'icon-link',
            //         'order' => '6',
            //     ]);
            // }

            // if (\Auth::user()->can('admin.links.create')) {
            //     \AdminMenu::register('links.create', [
            //         'parent'    =>  'links',
            //         'label'     =>  trans('links.add-new-links'),
            //         'url'       =>  route('admin.links.create'),
            //         'icon'      =>  'icon-note',
            //     ]);
            // }

            // if (\Auth::user()->can('admin.links.index')) {
            //     \AdminMenu::register('links.all', [
            //         'parent'    =>  'links',
            //         'label'     =>  trans('links.list-links'),
            //         'url'       =>  route('admin.links.index'),
            //         'icon'      =>  'icon-magnifier',
            //     ]);
            // }
        });
    }
}