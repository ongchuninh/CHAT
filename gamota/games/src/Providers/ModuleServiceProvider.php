<?php
/**
 * ModuleAlias: news
 * ModuleName: news
 * Description: This is the first file run of module. You can assign bootstrap or register module services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Gamota\Games\Providers;

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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Games');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'Games');

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
        \AccessControl::define(trans('weapon.weapon') .' - '. trans('weapon.list-weapon'), 'admin.games.index');
        \AccessControl::define(trans('weapon.weapon') .' - '. trans('weapon.add-new-weapon'), 'admin.games.create');
        \AccessControl::define(trans('weapon.weapon') .' - '. trans('weapon.edit-weapon'), 'admin.games.edit');
        \AccessControl::define(trans('weapon.weapon') .' - '. trans('weapon.disable-weapon'), 'admin.games.disable');
        \AccessControl::define(trans('weapon.weapon') .' - '. trans('weapon.enable-weapon'), 'admin.games.enable');
        \AccessControl::define(trans('weapon.weapon') .' - '. trans('weapon.destroy-weapon'), 'admin.games.destroy');
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
            if (\Auth::user()->can('admin.games.index')) {
                \AdminMenu::register('games', [
                    'parent'    =>  'main-manage',
                    'label'     =>  'Game',
                    'url'       =>  route('admin.game.index'),
                    'icon'      =>  'icon-notebook',
                    'order' => '5',
                ]);
            }

            if (\Auth::user()->can('admin.games.create')) {
                \AdminMenu::register('games.create', [
                    'parent'    =>  'games',
                    'label'     =>  'Thêm mới game',
                    'url'       =>  route('admin.game.create'),
                    'icon'      =>  'icon-note',
                ]);
            }

            if (\Auth::user()->can('admin.games.index')) {
                \AdminMenu::register('games.all', [
                    'parent'    =>  'games',
                    'label'     =>  'Danh sách game',
                    'url'       =>  route('admin.game.index'),
                    'icon'      =>  'icon-magnifier',
                ]);
            }
        });
    }
}