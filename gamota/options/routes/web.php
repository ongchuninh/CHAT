<?php



Route::group(['module' => 'option', 'namespace' => 'Gamota\Options\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin/option'], function () {
    Route::get('/custom-home', 'OptionController@showHome')->name('admin.option.home')->middleware('can:admin.option.index');
    Route::post('/custom-home', 'OptionController@updateHome')->name('admin.option.updateHome')->middleware('can:admin.option.index');
   

    Route::get('/custom-gamota', 'OptionController@gamota')->name('admin.option.gamota')->middleware('can:admin.option.index');
    Route::post('/custom-gamota', 'OptionController@updateGamota')->name('admin.option.updateGamota')->middleware('can:admin.option.index');

    Route::get('/setting-games', 'OptionController@games')->name('admin.option.games')->middleware('can:admin.option.index');
    Route::post('/setting-games', 'OptionController@updateGames')->name('admin.option.updateGames')->middleware('can:admin.option.index');

    Route::get('/setting-contact', 'OptionController@contact')->name('admin.option.contact')->middleware('can:admin.option.index');
    Route::post('/setting-contact', 'OptionController@updateContact')->name('admin.option.updateContact')->middleware('can:admin.option.index');

    Route::get('/setting-service', 'OptionController@service')->name('admin.option.service')->middleware('can:admin.option.index');
    Route::post('/setting-service', 'OptionController@updateService')->name('admin.option.updateService')->middleware('can:admin.option.index');

    Route::get('/', 'OptionController@general')->name('admin.option.general')->middleware('can:admin.option.index');
    Route::post('/', 'OptionController@updateGeneral')->name('admin.option.updateGeneral')->middleware('can:admin.option.index');

    Route::get('/language', 'OptionController@language')->name('admin.option.language')->middleware('can:admin.option.index');
    Route::post('/language', 'OptionController@updateLanguage')->name('admin.option.updateLanguage')->middleware('can:admin.option.index');

    
});