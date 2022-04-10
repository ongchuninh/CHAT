<?php

Route::group(['module' => 'gallery', 'namespace' => 'Gamota\Gallery\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin/gallery'], function () {
    Route::get('/', 'GalleryController@index')->name('admin.gallery.index')->middleware('can:admin.gallery.index');
    Route::get('create', 'GalleryController@create')->name('admin.gallery.create')->middleware('can:admin.gallery.create');
    Route::post('/', 'GalleryController@store')->name('admin.gallery.store')->middleware('can:admin.gallery.create');
    Route::get('{gallery}/edit', 'GalleryController@edit')->name('admin.gallery.edit')->middleware('can:admin.gallery.edit,gallery');
    Route::put('{gallery}', 'GalleryController@update')->name('admin.gallery.update')->middleware('can:admin.gallery.edit,gallery');
    Route::put('{gallery}/disable', 'GalleryController@disable')->name('admin.gallery.disable')->middleware('can:admin.gallery.disable,gallery');
    Route::put('{gallery}/enable', 'GalleryController@enable')->name('admin.gallery.enable')->middleware('can:admin.gallery.enable,gallery');

    Route::post('/applyStatus/{status?}', 'GalleryController@applyStatus')->name('admin.gallery.applyStatus')->middleware('can:admin.gallery.enable,gallery');
    Route::delete('/applyStatus/{status?}', 'GalleryController@applyStatus')->name('admin.gallery.applyStatus')->middleware('can:admin.gallery.destroy,gallery');

    Route::delete('{gallery}', 'GalleryController@destroy')->name('admin.gallery.destroy')->middleware('can:admin.gallery.destroy,gallery');

    Route::get('test', 'GalleryController@test')->name('admin.gallery.test');//TestbyTan

    Route::get('category/', 'CategoryController@index')->name('admin.gallery.category.index')->middleware('can:admin.gallery.category.index');
    Route::get('category/create', 'CategoryController@create')->name('admin.gallery.category.create')->middleware('can:admin.gallery.category.create');
    Route::post('category/', 'CategoryController@store')->name('admin.gallery.category.store')->middleware('can:admin.gallery.category.create');
    Route::get('category/{category}', 'CategoryController@show')->name('admin.gallery.category.show')->middleware('can:admin.gallery.category.show,category');
    Route::get('category/{category}/edit', 'CategoryController@edit')->name('admin.gallery.category.edit')->middleware('can:admin.gallery.category.edit,category');
    Route::put('category/{category}', 'CategoryController@update')->name('admin.gallery.category.update')->middleware('can:admin.gallery.category.edit,category');
    Route::put('category/{category}/disable', 'CategoryController@disable')->middleware('can:admin.gallery.category.disable,category');
    Route::put('category/{category}/enable', 'CategoryController@enable')->middleware('can:admin.gallery.category.enable,category');
    Route::delete('category/applyStatus/{status?}', 'CategoryController@applyStatus')->name('admin.gallery.category.destroy')->middleware('can:admin.gallery.category.destroy,category');
});
