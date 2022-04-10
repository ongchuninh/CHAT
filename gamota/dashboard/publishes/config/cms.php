<?php

return [
    'dashboard-view-path'       => 'Cms::admin.dashboard',
    'upload_path'               => public_path('storage'),
    'thumb_path'                => public_path('storage/thumbs'),

    'providers' => [
        \Ixudra\Curl\CurlServiceProvider::class,
        \Collective\Html\HtmlServiceProvider::class,
        \Intervention\Image\ImageServiceProvider::class,
        \Gamota\Dashboard\Providers\RoutingServiceProvider::class,

        /**
         * Gamota providers
         */
        
        \Gamota\Appearance\Providers\ModuleServiceProvider::class,
        \Gamota\Appearance\Providers\RoutingServiceProvider::class,
        \Gamota\News\Providers\ModuleServiceProvider::class,
        \Gamota\News\Providers\RoutingServiceProvider::class,
        \Gamota\Page\Providers\ModuleServiceProvider::class,
        \Gamota\Page\Providers\RoutingServiceProvider::class,
        \Gamota\Gallery\Providers\ModuleServiceProvider::class,
        \Gamota\Gallery\Providers\RoutingServiceProvider::class,
        \Gamota\Links\Providers\ModuleServiceProvider::class,
        \Gamota\Links\Providers\RoutingServiceProvider::class,
        \Gamota\Slider\Providers\ModuleServiceProvider::class,
        \Gamota\Slider\Providers\RoutingServiceProvider::class,
        \Gamota\Promise\Providers\ModuleServiceProvider::class,
        \Gamota\Promise\Providers\RoutingServiceProvider::class,
        \Gamota\FbComment\Providers\ModuleServiceProvider::class,
        \Gamota\FbComment\Providers\RoutingServiceProvider::class,
        \Gamota\CmsInstall\Providers\ModuleServiceProvider::class,
        \Gamota\CmsInstall\Providers\RoutingServiceProvider::class,
        \Gamota\Event\Providers\ModuleServiceProvider::class,
        \Gamota\Event\Providers\RoutingServiceProvider::class,
        /*/

        /**
         * Dev
         */
        
        \Gamota\CmsDev\Providers\ModuleServiceProvider::class,
        \Gamota\CmsDev\Providers\RoutingServiceProvider::class,
        
    ],

    'aliases' => [
        'Form'              =>  \Collective\Html\FormFacade::class,
        'Html'              =>  \Collective\Html\HtmlFacade::class,
        'AccessControl'     =>  \Gamota\Dashboard\Support\Facades\AccessControl::class,
        'AdminController'   =>  \Gamota\Dashboard\Http\Controllers\Admin\AdminController::class,
        'AdminMenu'         =>  \Gamota\Dashboard\Support\Facades\AdminMenu::class,
        'Contact'           =>  \Dashboard\Support\Facades\Contact::class,
        'Module'            =>  \Gamota\Dashboard\Support\Facades\Module::class,
        'Setting'           =>  \Gamota\Dashboard\Support\Facades\Setting::class,
        'Widget'            =>  \Dashboard\Support\Facades\Widget::class,
        'HomeController'    =>  \Dashboard\Http\Controllers\HomeController::class,
        'AppController'     =>  \Gamota\Dashboard\Http\Controllers\AppController::class,
        'ApiController'     =>  \Gamota\Dashboard\Http\Controllers\ApiController::class,
        'Language'          =>  \Gamota\Dashboard\Support\Facades\Language::class,
        'Action'            =>  \Gamota\Dashboard\Support\Facades\Action::class,
        'Filter'            =>  \Gamota\Dashboard\Support\Facades\Filter::class,
        'Metatag'           =>  \Gamota\Dashboard\Support\Facades\Metatag::class,
        'Asset'             =>  \Gamota\Dashboard\Support\Facades\Asset::class,
        'Install'           =>  \Gamota\CmsInstall\Support\Facades\Install::class,
        'EnvReader'         =>  \Gamota\CmsInstall\Support\Facades\EnvReader::class,
        'Curl'              =>  \Ixudra\Curl\Facades\Curl::class,
        'Image'             =>  \Intervention\Image\Facades\Image::class,

        /**
         * Phambinh alias
         */
        'Menu'              =>  \Gamota\Appearance\Support\Facades\Menu::class,
        'FbComment'         =>  \FbComment\Support\Facades\Comment::class,
        
    ],

    'commands' => [
        \Gamota\CmsInstall\Console\Commands\CmsInstall::class,
        \Gamota\CmsDev\Console\Commands\MakePackage::class,
        \Gamota\CmsDev\Console\Commands\MakeController::class,
        \Gamota\CmsDev\Console\Commands\MakeCommand::class,
        \Gamota\CmsDev\Console\Commands\MakeEvent::class,
        \Gamota\CmsDev\Console\Commands\MakeJob::class,
        \Gamota\CmsDev\Console\Commands\MakeListener::class,
        \Gamota\CmsDev\Console\Commands\MakeMail::class,
        \Gamota\CmsDev\Console\Commands\MakeMiddleware::class,
        \Gamota\CmsDev\Console\Commands\MakeModel::class,
        \Gamota\CmsDev\Console\Commands\MakeNotification::class,
        \Gamota\CmsDev\Console\Commands\MakePolicy::class,
        \Gamota\CmsDev\Console\Commands\MakeProvider::class,
        \Gamota\CmsDev\Console\Commands\MakeRequest::class,
        \Gamota\CmsDev\Console\Commands\MakeWidget::class,
    ],
];
