<?php



Route::group(['module' => 'game', 'namespace' => 'Gamota\Games\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin/game'], function () {
    Route::get('/', 'GameController@index')->name('admin.game.index')->middleware('can:admin.games.index');
    Route::get('create', 'GameController@create')->name('admin.game.create')->middleware('can:admin.games.create');
    Route::post('/', 'GameController@store')->name('admin.game.store')->middleware('can:admin.games.create');
    Route::get('{game}/edit', 'GameController@edit')->name('admin.game.edit');//->middleware('can:admin.games.edit.game');
    Route::put('{game}', 'GameController@update')->name('admin.game.update');//->middleware('can:admin.games.edit.game');
    Route::put('{game}/disable', 'GameController@disable')->name('admin.game.disable')->middleware('can:admin.games.disable.game');
    Route::put('{game}/enable', 'GameController@enable')->name('admin.game.enable')->middleware('can:admin.games.enable.game');
    Route::delete('{game}', 'GameController@destroy')->name('admin.game.destroy')->middleware('can:admin.games.destroy.game');

    Route::delete('/appply/{status}', 'GameController@appplyStatusGame')->name('admin.games.destroys')->middleware('can:admin.games.destroy');;


    Route::post('updateGame','GameController@updateGameFromGame')->name('admin.games.updateGame')->middleware('can:admin.games.create');
    
    
    
});