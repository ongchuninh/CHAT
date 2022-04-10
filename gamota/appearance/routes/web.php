<?php
/**
 * ModuleAlias: appearance
 * ModuleName: appearance
 * Description: Route of module appearance.This bellow have 3 type route: normal rotue, admin route, api route
 * to use, you have to uncommnet it
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */

Route::group(['module' => 'appearance', 'namespace' => 'Gamota\Appearance\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin/appearance'], function () {
    Route::get('menu', 'MenuController@index')->name('admin.appearance.menu.index')->middleware('can:admin.appearance.menu.index');
    Route::get('menu/{menu}', 'MenuController@menuEdit')->name('admin.appearance.menu.edit')->middleware('can:admin.appearance.menu.edit,menu');
    Route::put('menu/{menu}', 'MenuController@menuUpdate')->name('admin.appearance.menu.update')->middleware('can:admin.appearance.menu.edit,menu');
    Route::put('menu/{menu}/struct', 'MenuController@menuUpdateStruct')->name('admin.appearance.menu.update.struct')->middleware('can:admin.appearance.menu.edit,menu');
    Route::post('menu', 'MenuController@menuStore')->name('admin.appearance.menu.store');
    Route::post('menu/{menu}', 'MenuController@menuAdd')->name('admin.appearance.menu.add')->middleware('can:admin.appearance.menu.edit,menu');
    Route::post('menu/{menu}/default', 'MenuController@menuAddByDefault')->name('admin.appearance.menu.add-default')->middleware('can:admin.appearance.menu.edit,menu');
    Route::delete('menu/{menu}', 'MenuController@menuDestroy')->name('admin.appearance.menu.destroy')->middleware('can:admin.appearance.menu.destroy,menu');

    Route::put('menu-item/{menu_item}', 'MenuController@menuItemUpdate')->name('admin.appearance.menu-item.update')->middleware('can:admin.appearance.menu.edit');
    Route::delete('menu-item/{menu_item}', 'MenuController@menuItemDestroy')->name('admin.appearance.menu-item.destroy')->middleware('can:admin.appearance.menu.edit');

    Route::get('style-guide', 'StyleGuideController@index')->name('admin.appearance.style-guide.index')->middleware('can:admin');

    /* BEGIN OF FRONTEND */
    Route::get('frontend', 'FrontendController@index')->name('admin.appearance.frontend.index')->middleware('can:admin.appearance.frontend.index');
    Route::get('frontend/create', 'FrontendController@create')->name('admin.appearance.frontend.create')->middleware('can:admin.appearance.frontend.create');
    Route::post('frontend', 'FrontendController@store')->name('admin.appearance.frontend.store')->middleware('can:admin.appearance.frontend.create');;
    Route::get('{frontend}/edit', 'FrontendController@edit')->name('admin.appearance.frontend.edit')->middleware('can:admin.appearance.frontend.edit,frontend');
    Route::put('{frontend}', 'FrontendController@update')->name('admin.appearance.frontend.update')->middleware('can:admin.appearance.frontend.edit,frontend');
    Route::delete('frontend/{frontend}', 'FrontendController@destroy')->name('admin.appearance.frontend.destroy')->middleware('can:admin.appearance.frontend.destroy,frontend');
    Route::delete('frontend/applyStatus/{status?}', 'FrontendController@applyStatus')->name('admin.appearance.frontend.applyStatus')->middleware('can:admin.appearance.frontend.destroy,frontend');
});
