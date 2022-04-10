<?php

Route::group(['module' => 'links', 'namespace' => 'Gamota\Links\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin/links'], function () {
    Route::get('/', 'LinksController@index')->name('admin.links.index')->middleware('can:admin.links.index');
    Route::get('create', 'LinksController@create')->name('admin.links.create')->middleware('can:admin.links.create');
    Route::post('/', 'LinksController@store')->name('admin.links.store')->middleware('can:admin.links.create');
    Route::get('{links}/edit', 'LinksController@edit')->name('admin.links.edit')->middleware('can:admin.links.edit,links');
    Route::put('{links}', 'LinksController@update')->name('admin.links.update')->middleware('can:admin.links.edit,links');
    Route::put('{links}/disable', 'LinksController@disable')->name('admin.links.disable')->middleware('can:admin.links.disable,links');
    Route::put('{links}/enable', 'LinksController@enable')->name('admin.links.enable')->middleware('can:admin.links.enable,links');
    Route::delete('{links}', 'LinksController@destroy')->name('admin.links.destroy')->middleware('can:admin.links.destroy,links');
});