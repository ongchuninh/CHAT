<?php
/**
 * ModuleAlias: news
 * ModuleName: news
 * Description: This is the first file run of module. You can assign bootstrap or register module services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Gamota\Contacts\Providers;

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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Contacts');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'Contacts');

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

    //đăng ký phân quyền
    public function registerPolicies()
    {
        \AccessControl::define(trans('weapon.weapon') .' - '. trans('weapon.list-weapon'), 'admin.contacts.index');
        \AccessControl::define(trans('weapon.weapon') .' - '. trans('weapon.add-new-weapon'), 'admin.contacts.create');
        \AccessControl::define(trans('weapon.weapon') .' - '. trans('weapon.edit-weapon'), 'admin.contacts.edit');
        \AccessControl::define(trans('weapon.weapon') .' - '. trans('weapon.disable-weapon'), 'admin.contacts.disable');
        \AccessControl::define(trans('weapon.weapon') .' - '. trans('weapon.enable-weapon'), 'admin.contacts.enable');
        \AccessControl::define(trans('weapon.weapon') .' - '. trans('weapon.destroy-weapon'), 'admin.contacts.destroy');
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
            if (\Auth::user()->can('admin.contacts.index')) {
                \AdminMenu::register('contacts', [
                    'parent'    =>  'main-manage',
                    'label'     =>  'Liên hệ',
                    'url'       =>  route('admin.contact.index'),
                    'icon'      =>  'icon-notebook',
                    'order' => '5',
                ]);
            }

            

            if (\Auth::user()->can('admin.contacts.index')) {
                \AdminMenu::register('contacts.all', [
                    'parent'    =>  'contacts',
                    'label'     =>  'Danh sách Liên hệ',
                    'url'       =>  route('admin.contact.index'),
                    'icon'      =>  'icon-magnifier',
                ]);
            }
        });
    }
}