<?php

Route::group(['module' => 'slider', 'namespace' => 'Gamota\Slider\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin/slider'], function () {
    Route::get('/', 'SliderController@index')->name('admin.slider.index')->middleware('can:admin.slider.index');
    Route::get('create', 'SliderController@create')->name('admin.slider.create')->middleware('can:admin.slider.create');
    Route::post('/', 'SliderController@store')->name('admin.slider.store')->middleware('can:admin.slider.create');
    Route::get('{slider}/edit', 'SliderController@edit')->name('admin.slider.edit')->middleware('can:admin.slider.edit,slider');
    Route::put('{slider}', 'SliderController@update')->name('admin.slider.update')->middleware('can:admin.slider.edit,slider');
    Route::put('{slider}/disable', 'SliderController@disable')->name('admin.slider.disable')->middleware('can:admin.slider.disable,slider');
    Route::put('{slider}/enable', 'SliderController@enable')->name('admin.slider.enable')->middleware('can:admin.slider.enable,slider');
    Route::delete('{slider}', 'SliderController@destroy')->name('admin.slider.destroy')->middleware('can:admin.slider.destroy,slider');
});