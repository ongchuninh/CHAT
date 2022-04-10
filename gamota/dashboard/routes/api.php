<?php

Route::group(['module' => 'dashboard', 'namespace' => 'Gamota\Dashboard\Http\Controllers\Api', 'prefix' => 'api/dashboard'], function () {
    Route::get('user', 'UserController@index')->name('api.user.index');
    Route::get('gen-api-token', 'UserController@genApiToken')->name('api.user.gen-api-token');
});
