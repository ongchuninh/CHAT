<?php 

Route::group(['package' => 'promise', 'middleware' => ['web'], 'namespace' => 'Admin', 'prefix' => 'admin/promise'], function () {
    Route::get('/', 'PromiseController@index')->name('admin.promise.index');
});
